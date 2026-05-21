<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDetailResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Midtrans\Config;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        
        // Sinkronisasi status order yang belum dibayar dengan API Midtrans secara real-time
        $unpaidOrders = Order::where('user_id', $user_id)->where('status', 'Unpaid')->get();
        if (!blank(config('midtrans.server_key')) && $unpaidOrders->isNotEmpty()) {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = (bool) config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            foreach ($unpaidOrders as $order) {
                try {
                    $status = \Midtrans\Transaction::status($order->order_id);
                    $transactionStatus = strtolower((string) $status->transaction_status);
                    $paidStatuses = ['settlement', 'capture'];

                    if (in_array($transactionStatus, $paidStatuses, true)) {
                        DB::transaction(function () use ($order, $status) {
                            $order->load('items');
                            $payment = Payment::where('order_id', $order->id)->lockForUpdate()->first();
                            if ($payment) {
                                $payment->status = $status->transaction_status ?: $payment->status;
                                $payment->transaction_id = $status->transaction_id ?: $payment->transaction_id;
                                $payment->type = $status->payment_type ?: $payment->type;
                                $payment->save();
                            }

                            foreach ($order->items as $item) {
                                $product = Product::whereKey($item->product_id)->lockForUpdate()->first();
                                if ($product) {
                                    $product->quantity = max(0, $product->quantity - $item->quantity);
                                    $product->inStock = $product->quantity > 0 ? 1 : 0;
                                    $product->save();
                                }
                            }

                            $order->status = 'Paid';
                            $order->paid_at = $status->transaction_time ?: now();
                            $order->save();

                            $this->clearPaidCartItems($order);
                        });
                    }
                } catch (\Exception $e) {
                    // Abaikan jika transaksi belum dibuat di Midtrans sandbox
                }
            }
        }

        $orders = Order::with('items', 'items.product')->where('user_id', $user_id)->latest()->paginate(10);
        $stats = [
            'total' => Order::where('user_id', $user_id)->count(),
            'unpaid' => Order::where('user_id', $user_id)->where('status', 'Unpaid')->count(),
            'paid' => Order::where('user_id', $user_id)->where('status', 'Paid')->count(),
        ];

        return Inertia::render('User/Dashboard', [
            'orders' => $orders,
            'stats' => $stats,
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $orderId = data_get($request->input('order'), 'id');

        return $this->renderPaymentPage($request, $orderId);
    }

    public function show(Request $request, Order $order)
    {
        return $this->renderPaymentPage($request, $order->id);
    }

    private function renderPaymentPage(Request $request, int|string|null $orderId)
    {
        abort_if(blank(config('midtrans.server_key')) || blank(config('midtrans.client_key')), 503, 'Midtrans sandbox credentials are not configured');

        $order = Order::with(['items.product', 'payment', 'userAddress'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($orderId);
        abort_if($order->status === 'Paid', 422, 'Order has already been paid');

        $user = $request->user();
        $userAddress = $order->userAddress;
        abort_if(!$userAddress, 422, 'Shipping address not found for this order');
        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = (bool) config('midtrans.is_production');
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->order_id,
                'gross_amount' => intval($order->gross_amount + $order->courir_price),
            ),
            'customer_details' => array(
                'first_name' => 'Mr',
                'last_name' => $user->name,
                'email' => $user->email,
                'phone' => $userAddress->no_hp,
            ),
        );

        $total_price = $order->gross_amount + $order->courir_price;
        $total_product = $order->items->sum('quantity');
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return Inertia::render('User/Payment', [
            'order' => $order,
            'total_product' => $total_product,
            'total_price' => $total_price,
            'token' => $snapToken,
            'snap_redirect_url' => rtrim(config('midtrans.snap_redirect_url'), '/') . '/' . $snapToken,
        ]);
    }

    public function response(Request $request){
        $server_key = config('midtrans.server_key');
        abort_if(blank($server_key), 503, 'Midtrans server key is not configured');
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$server_key);
        abort_if($hashed !== $request->signature_key, 403, 'Invalid payment signature');

        $transactionStatus = strtolower((string) $request->transaction_status);
        $paidStatuses = ['settlement', 'capture'];

        DB::transaction(function () use ($request, $transactionStatus, $paidStatuses) {
            $order = Order::where('order_id', $request->order_id)->lockForUpdate()->first();
            if (!$order) {
                return;
            }

            $order->load('items');

            $payment = Payment::where('order_id', $order->id)->lockForUpdate()->first();
            if ($payment) {
                $payment->status = $transactionStatus ?: $payment->status;
                $payment->transaction_id = $request->transaction_id ?: $payment->transaction_id;
                $payment->type = $request->payment_type ?: $payment->type;
                $payment->save();
            }

            if (in_array($transactionStatus, $paidStatuses, true) && $order->status !== 'Paid') {
                foreach ($order->items as $item) {
                    $product = Product::whereKey($item->product_id)->lockForUpdate()->firstOrFail();
                    $product->quantity = max(0, $product->quantity - $item->quantity);
                    $product->inStock = $product->quantity > 0 ? 1 : 0;
                    $product->save();
                }

                $order->status = 'Paid';
                $order->paid_at = $request->transaction_time ?: now();
                $order->save();

                $this->clearPaidCartItems($order);
            }
        });

        return response()->noContent();
    }

    private function clearPaidCartItems(Order $order): void
    {
        foreach ($order->items as $item) {
            $cart = Cart::where('user_id', $order->user_id)
                ->where('product_id', $item->product_id)
                ->whereNull('paid_at')
                ->lockForUpdate()
                ->first();

            if (!$cart) {
                continue;
            }

            if ($cart->quantity <= $item->quantity) {
                $cart->delete();
                continue;
            }

            $cart->quantity -= $item->quantity;
            $cart->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function invoice($id)
    {
        $order = Order::with(['items.product', 'userAddress.user'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $user = $order->userAddress;

        $data = $order->items->map(fn ($item) => [
            'order_id' => $order->order_id,
            'title' => $item->product?->title,
            'gross_amount' => intval($order->gross_amount),
            'quantity' => $item->quantity,
            'unit_price' => $item->unit_price,
            'status' => $order->status,
            'paid_at' => $order->paid_at,
            'courir' => $order->courir,
            'courir_type' => $order->courir_type,
            'courir_price' => $order->courir_price,
        ])->values();
        $sub_total = intval($order->gross_amount);
        $total_price = $order->gross_amount + $order->courir_price;

        return Inertia::render('User/Invoice', [
            'order' => $order,
            'sub_total' => $sub_total,
            'total_price' => $total_price,
            'data' => $data,
            'user' => $user
        ]);
    }

}

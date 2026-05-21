<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Sinkronisasi status order yang belum dibayar dengan API Midtrans
        $unpaidOrders = Order::where('status', 'Unpaid')
            ->where('created_at', '>=', now()->subDays(30))
            ->get();

        if (!blank(config('midtrans.server_key')) && $unpaidOrders->isNotEmpty()) {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = (bool) config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            foreach ($unpaidOrders as $order) {
                try {
                    $status = \Midtrans\Transaction::status($order->order_id);
                    $transactionStatus = strtolower((string) $status->transaction_status);
                    $paidStatuses = ['settlement', 'capture'];

                    if (in_array($transactionStatus, $paidStatuses, true)) {
                        \Illuminate\Support\Facades\DB::transaction(function () use ($order, $status) {
                            $order->load('items');
                            $payment = \App\Models\Payment::where('order_id', $order->id)->lockForUpdate()->first();
                            if ($payment) {
                                $payment->status = $status->transaction_status ?: $payment->status;
                                $payment->transaction_id = $status->transaction_id ?: $payment->transaction_id;
                                $payment->type = $status->payment_type ?: $payment->type;
                                $payment->save();
                            }

                            foreach ($order->items as $item) {
                                $product = \App\Models\Product::whereKey($item->product_id)->lockForUpdate()->first();
                                if ($product) {
                                    $product->quantity = max(0, $product->quantity - $item->quantity);
                                    $product->inStock = $product->quantity > 0 ? 1 : 0;
                                    $product->save();
                                }
                            }

                            $order->status = 'Paid';
                            $order->paid_at = $status->transaction_time ?: now();
                            $order->save();

                            // Bersihkan cart items
                            foreach ($order->items as $item) {
                                $cart = \App\Models\Cart::where('user_id', $order->user_id)
                                    ->where('product_id', $item->product_id)
                                    ->whereNull('paid_at')
                                    ->lockForUpdate()
                                    ->first();

                                if ($cart) {
                                    if ($cart->quantity <= $item->quantity) {
                                        $cart->delete();
                                    } else {
                                        $cart->quantity -= $item->quantity;
                                        $cart->save();
                                    }
                                }
                            }
                        });
                    }
                } catch (\Exception $e) {
                    // Abaikan kesalahan
                }
            }
        }

        $stats = [
            'total' => Order::count(),
            'paid' => Order::where('status', 'Paid')->count(),
            'unpaid' => Order::where('status', 'Unpaid')->count(),
            'revenue' => Order::where('status', 'Paid')
                ->selectRaw('COALESCE(SUM(gross_amount + courir_price), 0) as total')
                ->value('total'),
        ];

        $orders = Order::with('items', 'items.product', 'items.product.category', 'items.product.brand', 'items.product.product_images')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('order_id', 'like', '%' . $search . '%')
                        ->orWhere('status', 'like', '%' . $search . '%')
                        ->orWhere('courir', 'like', '%' . $search . '%')
                        ->orWhere('courir_type', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->fastPaginate(10);
        return Inertia::render('Admin/Order/Index',[
            'orders' => $orders,
            'filters' => $request->only(['search']),
            'stats' => $stats,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function invoice($id)
    {
        $order = Order::with(['items.product.category', 'items.product.brand', 'items.product.product_images', 'userAddress.user'])
            ->where('id', $id)
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
        return Inertia::render('Admin/Order/Invoice', [
            'order' => $order,
            'sub_total' => $sub_total,
            'total_price' => $total_price,
            'data' => $data,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

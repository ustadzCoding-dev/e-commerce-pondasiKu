<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\UserAddress;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(private readonly ShippingService $shippingService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $user = $request->user();
        $validated = $request->validate([
            'items.shipping' => ['required', 'string'],
        ]);
        $userAddress = UserAddress::where('user_id', $user->id)->where('isMain', 1)->firstOrFail();

        $order_id = 'order-'.now()->format('Y').$request->user()->id.now()->format('Hm-s').rand(1, 10);

        $cartItems = Cart::with('product')->where(['user_id' => $user->id])->whereNull('paid_at')->get();
        abort_if($cartItems->isEmpty(), 422, 'Cart is empty');
        abort_if(
            $cartItems->contains(fn (Cart $cartItem) => !$cartItem->product || (int) $cartItem->product->quantity < $cartItem->quantity),
            422,
            'One or more cart items are out of stock'
        );

        $shippingOption = $this->resolveShippingSelection($validated['items']['shipping'], $userAddress);
        $subtotal = $cartItems->sum(fn (Cart $cartItem) => (float) $cartItem->product->price * $cartItem->quantity);
        $paymentTotal = $subtotal + $shippingOption['price'];

        $createdOrder = null;
        DB::transaction(function () use ($cartItems, $order_id, $user, $userAddress, $subtotal, $shippingOption, $paymentTotal, &$createdOrder) {
            $order = new Order;
            $order->order_id = $order_id;
            $order->user_id = $user->id;
            $order->status = 'Unpaid';
            $order->gross_amount = $subtotal;
            $order->courir = $shippingOption['name'];
            $order->courir_type = $shippingOption['type'];
            $order->courir_price = $shippingOption['price'];
            $order->created_by = $user->id;
            $order->user_address_id = $userAddress->id;
            $order->save();

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->product->price,
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'amount' => $paymentTotal,
                'status' => 'pending',
                'type' => 'online',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            $createdOrder = $order;
        });

        // Redirect langsung ke halaman pembayaran Midtrans, bukan ke dashboard
        return redirect()->route('pay.show', $createdOrder)->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    private function resolveShippingSelection(string $shippingSelection, UserAddress $userAddress): array
    {
        $shippingParts = explode('-', $shippingSelection);
        if (count($shippingParts) < 2) {
            abort(422, 'Invalid shipping selection');
        }

        [$selectedName, $selectedType] = array_slice($shippingParts, 0, 2);

        $shippingOption = collect($this->shippingService->getShippingOptions($userAddress))
            ->first(fn (array $option) => $option['name'] === $selectedName && $option['type'] === $selectedType);

        abort_if(!$shippingOption, 422, 'Shipping option not available');

        return $shippingOption;
    }
}

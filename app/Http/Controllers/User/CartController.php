<?php

namespace App\Http\Controllers\User;

use App\Helper\CartHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\UserAddress;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class CartController extends Controller
{
    public function __construct(
        private readonly ShippingService $shippingService,
        private readonly \App\Services\CartService $cartService
    ) {
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
    public function store(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->post('quantity', 1));
        $this->cartService->addItem($product, $quantity, $request->user());

        return redirect()->back()->with('success', 'cart added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Product $product)
    {
        $user = $request->user();
        $provinces = $this->shippingService->getProvinces();

        if ($user) {
            $carts = Cart::with('product', 'product_image')
                ->where('user_id', $user->id)
                ->whereNull('paid_at')
                ->get();
            $userAddress = UserAddress::where('user_id', $user->id)->where('isMain', 1)->first();
            $shippingCosts = $userAddress ? $this->shippingService->getShippingOptions($userAddress) : [];

            return Inertia::render('User/CartList', [
                'carts' => $carts,
                'count' => $carts->count(),
                'total' => $carts->sum(fn (Cart $cart) => (float) $cart->product->price * $cart->quantity),
                'provinces' => $provinces,
                'userAddress' => $userAddress,
                'shippings' => $shippingCosts,
            ]);
        } else {
            $cartItems = CartHelper::getCookieCartItems();
            if (count($cartItems) > 0) {
                $cart = new CartResource(CartHelper::getProductsAndCartItems());
                $cartData = $cart->toArray($request);
                $carts = collect($cartData['products'])->map(function ($product) use ($cartData) {
                    $productData = $product['data'] ?? $product;
                    $item = $cartData['items'][$productData['id']];

                    return [
                        'product_id' => $productData['id'],
                        'quantity' => $item['quantity'],
                        'product' => $productData,
                        'product_image' => $productData['product_images'] ?? [],
                    ];
                })->values();

                return Inertia::render('User/CartList', [
                    'carts' => $carts,
                    'count' => $cartData['count'],
                    'total' => $cartData['total'],
                    'provinces' => $provinces,
                    'userAddress' => null,
                    'shippings' => [],
                ]);
            } else {
                return Inertia::render('User/CartList', [
                    'carts' => [],
                    'count' => 0,
                    'total' => 0,
                    'provinces' => $provinces,
                    'userAddress' => null,
                    'shippings' => [],
                ]);
            }
        }

    }

    public function addAddress(Request $request)
    {
        $request->merge([
            'isMain' => $request->boolean('isMain'),
            'country_code' => $request->input('country_code') ?: 'ID',
        ]);
        $validated = $request->validate([
            'type' => ['required', 'string', 'max:45'],
            'address1' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:15'],
            'isMain' => ['required', 'boolean'],
            'postcode' => ['required', 'string', 'max:45'],
            'country_code' => ['required', 'string', 'max:3'],
            'city_id' => ['required', 'integer'],
            'prov_id' => ['required', 'integer'],
        ]);

        if ($validated['isMain']) {
            UserAddress::where('user_id', $request->user()->id)->update(['isMain' => false]);
        }

        $address = new UserAddress;
        $address->type = $validated['type'];
        $address->address1 = $validated['address1'];
        $address->no_hp = $validated['no_hp'];
        $address->isMain = $validated['isMain'];
        $address->postcode = $validated['postcode'];
        $address->country_code = $validated['country_code'];
        $address->city_id = $validated['city_id'];
        $address->prov_id = $validated['prov_id'];
        $address->user_id = $request->user()->id;

        $location = $this->shippingService->resolveAddressLocation($validated['prov_id'], $validated['city_id']);
        $address->province = $location['province'];
        $address->city = $location['city'];

        if ($address->save()){
            return redirect()->route('cart.show')->with('success', 'Address created successfully.');
        }else{
            return redirect()->back()->with('errors', 'Failed create address');
        }
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
    public function update(Request $request, Product $product)
    {
        $quantity = max(1, $request->integer('quantity'));
        $this->cartService->updateItem($product, $quantity, $request->user());

        return redirect()->back()->with('success', 'Success add quantity');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        $isEmpty = $this->cartService->removeItem($product, $request->user());

        if ($isEmpty) {
            return redirect()->route('home')->with('info', 'your cart is empty');
        } else {
            return redirect()->back()->with('success', 'item removed successfully');
        }
    }
}

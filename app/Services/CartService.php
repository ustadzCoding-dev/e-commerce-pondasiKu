<?php

namespace App\Services;

use App\Helper\CartHelper;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class CartService
{
    /**
     * Add an item to the cart.
     * Throws an exception if stock is insufficient.
     */
    public function addItem(Product $product, int $quantity, ?\App\Models\User $user): void
    {
        abort_if((int) $product->quantity < $quantity, 422, 'Insufficient product stock');

        if ($user) {
            $cartItem = Cart::where(['user_id' => $user->id, 'product_id' => $product->id])->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $quantity;
                abort_if((int) $product->quantity < $newQuantity, 422, 'Insufficient product stock');
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ]);
            }
            Cache::forget('carts_global_count');
        } else {
            $cartItems = CartHelper::getCookieCartItems();
            $isProductExist = false;
            foreach ($cartItems as &$item) {
                if ($item['product_id'] == $product->id) {
                    $newQuantity = $item['quantity'] + $quantity;
                    abort_if((int) $product->quantity < $newQuantity, 422, 'Insufficient product stock');
                    $item['quantity'] = $newQuantity;
                    $isProductExist = true;
                    break;
                }
            }
            unset($item);
            if (!$isProductExist) {
                $cartItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }
            CartHelper::setCookieCartItems($cartItems);
        }
    }

    /**
     * Update an item's quantity in the cart.
     * Throws an exception if stock is insufficient.
     */
    public function updateItem(Product $product, int $quantity, ?\App\Models\User $user): void
    {
        abort_if((int) $product->quantity < $quantity, 422, 'Insufficient product stock');

        if ($user) {
            Cart::query()->where(['user_id' => $user->id, 'product_id' => $product->id])
                ->update(['quantity' => $quantity]);
        } else {
            $cartItems = CartHelper::getCookieCartItems();
            foreach ($cartItems as &$item) {
                if ($item['product_id'] == $product->id) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }
            unset($item);
            CartHelper::setCookieCartItems($cartItems);
        }
        Cache::forget('carts_global_count');
    }

    /**
     * Remove an item from the cart.
     * Returns true if the cart is empty after removal.
     */
    public function removeItem(Product $product, ?\App\Models\User $user): bool
    {
        if ($user) {
            Cart::query()->where(['user_id' => $user->id, 'product_id' => $product->id])->first()?->delete();
            Cache::forget('carts_global_count');
            return Cart::where('user_id', $user->id)->whereNull('paid_at')->count() <= 0;
        } else {
            $cartItems = CartHelper::getCookieCartItems();
            foreach ($cartItems as $i => &$item) {
                if ($item['product_id'] === $product->id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            CartHelper::setCookieCartItems($cartItems);
            return count($cartItems) <= 0;
        }
    }
}

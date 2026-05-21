<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class WebsiteSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_product_pages(): void
    {
        $product = $this->createProduct();

        $this->get(route('product.index'))->assertOk();
        $this->get(route('product.view', $product->slug))->assertOk();
    }

    public function test_unpublished_products_are_hidden_from_public_catalog_and_detail_pages(): void
    {
        $published = $this->createProduct([
            'title' => 'Produk Tampil',
            'published' => 1,
        ]);

        $hidden = $this->createProduct([
            'title' => 'Produk Arsip',
            'slug' => 'produk-arsip',
            'published' => 0,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Produk Tampil')
            ->assertDontSee('Produk Arsip');

        $this->get(route('product.index'))
            ->assertOk()
            ->assertSee('Produk Tampil')
            ->assertDontSee('Produk Arsip');

        $this->get(route('product.view', $hidden->slug))
            ->assertNotFound();
    }

    public function test_guest_cart_page_renders_items_from_cookie_cart(): void
    {
        $product = $this->createProduct([
            'title' => 'Semen Tiga Roda',
        ]);

        $cookie = cookie('cart_items', json_encode([
            [
                'product_id' => $product->id,
                'quantity' => 2,
            ],
        ]));

        $this->withCookie($cookie->getName(), $cookie->getValue())
            ->get(route('cart.show'))
            ->assertOk()
            ->assertSee('Semen Tiga Roda');
    }

    public function test_empty_guest_cart_page_renders_without_redirecting(): void
    {
        $this->get(route('cart.show'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('User/CartList')
                ->where('count', 0)
                ->where('total', 0)
            );
    }

    public function test_checkout_recalculates_totals_on_the_server(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(['price' => 100, 'quantity' => 10]);

        UserAddress::create([
            'type' => 'home',
            'address1' => 'Jl. Mawar 1',
            'no_hp' => '08123456789',
            'province' => 'DI Yogyakarta',
            'city' => 'Yogyakarta',
            'postcode' => '55111',
            'isMain' => true,
            'country_code' => 'IDN',
            'city_id' => 501,
            'prov_id' => 5,
            'user_id' => $user->id,
        ]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'total' => 1,
            'items' => [
                'shipping' => 'JNE-REG-15000',
            ],
        ]);

        $response->assertRedirect(route('dashboard'));

        $order = Order::firstOrFail();
        $payment = Payment::firstOrFail();

        $this->assertSame('100.00', $product->fresh()->price);
        $this->assertEquals(200, (float) $order->gross_amount);
        $this->assertEquals(14000, (float) $order->courir_price);
        $this->assertEquals(14200, (float) $payment->amount);
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_shared_authenticated_user_props_do_not_expose_security_fields(): void
    {
        $user = User::factory()->create([
            'mfa_enabled' => true,
            'mfa_secret' => 'encrypted-secret',
            'backup_codes' => ['hashed-code'],
            'failed_login_attempts' => 3,
            'locked_until' => now()->addMinutes(10),
            'last_login_ip' => '127.0.0.1',
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($user->email)
            ->assertDontSee('mfa_secret')
            ->assertDontSee('encrypted-secret')
            ->assertDontSee('backup_codes')
            ->assertDontSee('failed_login_attempts')
            ->assertDontSee('locked_until')
            ->assertDontSee('last_login_ip');
    }

    public function test_cart_cannot_be_updated_beyond_available_stock(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(['price' => 50000, 'quantity' => 2]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($user)
            ->patch(route('cart.update', $product), [
                'quantity' => 3,
            ])
            ->assertStatus(422);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    public function test_user_cannot_view_another_users_invoice(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $address = UserAddress::create([
            'type' => 'home',
            'address1' => 'Jl. Melati 2',
            'no_hp' => '08111111111',
            'province' => 'DI Yogyakarta',
            'city' => 'Yogyakarta',
            'postcode' => '55111',
            'isMain' => true,
            'country_code' => 'IDN',
            'city_id' => 501,
            'prov_id' => 5,
            'user_id' => $owner->id,
        ]);

        $order = Order::create([
            'order_id' => 'ORDER-001',
            'user_id' => $owner->id,
            'gross_amount' => 100000,
            'status' => 'Paid',
            'courir' => 'JNE',
            'courir_type' => 'REG',
            'courir_price' => 15000,
            'user_address_id' => $address->id,
        ]);

        $this->actingAs($otherUser)
            ->get(route('invoice', $order->id))
            ->assertNotFound();
    }

    public function test_user_cannot_update_or_delete_another_users_address(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $address = UserAddress::create([
            'type' => 'home',
            'address1' => 'Jl. Kenanga 3',
            'no_hp' => '08222222222',
            'province' => 'DI Yogyakarta',
            'city' => 'Yogyakarta',
            'postcode' => '55111',
            'isMain' => true,
            'country_code' => 'IDN',
            'city_id' => 501,
            'prov_id' => 5,
            'user_id' => $otherUser->id,
        ]);

        $updatePayload = [
            'type' => 'home',
            'address1' => 'Diubah ilegal',
            'no_hp' => '08222222222',
            'postcode' => '55111',
            'isMain' => true,
            'country_code' => 'IDN',
            'city_id' => 501,
            'prov_id' => 5,
        ];

        $this->actingAs($owner)
            ->put(route('address.update', $address->id), $updatePayload)
            ->assertNotFound();

        $this->actingAs($owner)
            ->delete(route('address.delete', $address->id))
            ->assertNotFound();

        $this->assertDatabaseHas('user_addresses', [
            'id' => $address->id,
            'address1' => 'Jl. Kenanga 3',
        ]);
    }

    public function test_address_search_stays_scoped_to_authenticated_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        UserAddress::create([
            'type' => 'home',
            'address1' => 'Alamat Aman',
            'no_hp' => '08333333333',
            'province' => 'DI Yogyakarta',
            'city' => 'Yogyakarta',
            'postcode' => '55111',
            'isMain' => true,
            'country_code' => 'IDN',
            'city_id' => 501,
            'prov_id' => 5,
            'user_id' => $user->id,
        ]);

        UserAddress::create([
            'type' => 'office',
            'address1' => 'Target Bocor',
            'no_hp' => '08444444444',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'postcode' => '10110',
            'isMain' => true,
            'country_code' => 'IDN',
            'city_id' => 151,
            'prov_id' => 6,
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($user)
            ->get(route('address', ['search' => 'Target Bocor']))
            ->assertDontSee('Target Bocor');
    }

    public function test_admin_address_search_uses_real_address_fields(): void
    {
        $admin = User::factory()->create();
        $admin->isAdmin = 1;
        $admin->save();

        $customer = User::factory()->create([
            'name' => 'Pelanggan Tes',
            'email' => 'pelanggan@example.com',
        ]);

        UserAddress::create([
            'type' => 'office',
            'address1' => 'Jl. Beton No. 5',
            'no_hp' => '08555555555',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'postcode' => '40111',
            'isMain' => true,
            'country_code' => 'IDN',
            'city_id' => 79,
            'prov_id' => 9,
            'user_id' => $customer->id,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.user.addresses', ['search' => 'Beton']))
            ->assertOk()
            ->assertSee('Jl. Beton No. 5')
            ->assertSee('08555555555');
    }

    public function test_midtrans_callback_updates_payment_status_and_marks_order_paid(): void
    {
        config()->set('midtrans.server_key', 'test-server-key');

        $user = User::factory()->create();
        $product = $this->createProduct(['quantity' => 5]);
        $address = UserAddress::create([
            'type' => 'home',
            'address1' => 'Jl. Callback 10',
            'no_hp' => '08120000000',
            'province' => 'DI Yogyakarta',
            'city' => 'Yogyakarta',
            'postcode' => '55111',
            'isMain' => true,
            'country_code' => 'IDN',
            'city_id' => 501,
            'prov_id' => 5,
            'user_id' => $user->id,
        ]);

        $order = Order::create([
            'order_id' => 'ORDER-CALLBACK-1',
            'user_id' => $user->id,
            'gross_amount' => 200000,
            'status' => 'Unpaid',
            'courir' => 'JNE',
            'courir_type' => 'REG',
            'courir_price' => 15000,
            'user_address_id' => $address->id,
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 100000,
        ]);

        Payment::create([
            'order_id' => $order->id,
            'amount' => 215000,
            'status' => 'pending',
            'type' => 'online',
        ]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $grossAmount = '215000.00';
        $statusCode = '200';
        $signatureKey = hash('sha512', $order->order_id.$statusCode.$grossAmount.'test-server-key');

        $this->post(route('response'), [
            'order_id' => $order->order_id,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signatureKey,
            'transaction_status' => 'settlement',
            'transaction_time' => now()->toDateTimeString(),
            'transaction_id' => 'trx-demo-1',
            'payment_type' => 'bank_transfer',
        ])->assertNoContent();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'Paid',
        ]);

        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'status' => 'settlement',
            'transaction_id' => 'trx-demo-1',
            'type' => 'bank_transfer',
        ]);

        $this->assertEquals(3, $product->fresh()->quantity);
        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->post(route('response'), [
            'order_id' => $order->order_id,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signatureKey,
            'transaction_status' => 'settlement',
            'transaction_time' => now()->toDateTimeString(),
            'transaction_id' => 'trx-demo-1',
            'payment_type' => 'bank_transfer',
        ])->assertNoContent();

        $this->assertEquals(3, $product->fresh()->quantity);
    }

    private function createProduct(array $overrides = []): Product
    {
        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Kategori Test ' . fake()->unique()->word(),
            'slug' => Str::slug(fake()->unique()->words(3, true)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $brandId = DB::table('brands')->insertGetId([
            'name' => 'Brand Test ' . fake()->unique()->word(),
            'slug' => Str::slug(fake()->unique()->words(3, true)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return Product::factory()->create(array_merge([
            'category_id' => $categoryId,
            'brand_id' => $brandId,
            'published' => 1,
            'created_by' => null,
            'updated_by' => null,
        ], $overrides));
    }
}

<?php

namespace Tests\Feature;

use App\Models\UserAddress;
use App\Services\ShippingService;
use Tests\TestCase;

class ShippingServiceTest extends TestCase
{
    public function test_mock_provider_is_used_for_demo_even_when_api_key_exists(): void
    {
        putenv('SHIPPING_PROVIDER=mock');
        putenv('RAJAONGKIR_API_KEY=dummy-live-key');

        $address = new UserAddress([
            'prov_id' => 10,
            'city_id' => 104,
        ]);

        $options = app(ShippingService::class)->getShippingOptions($address);

        $this->assertCount(4, $options);
        $this->assertSame('JNE', $options[0]['name']);
        $this->assertSame('REG', $options[0]['type']);
        $this->assertSame(12000, $options[0]['price']);
    }

    public function test_mock_provider_is_rejected_in_production(): void
    {
        config()->set('app.env', 'production');
        putenv('SHIPPING_PROVIDER=mock');

        $this->expectException(\RuntimeException::class);

        app(ShippingService::class)->getShippingOptions(new UserAddress([
            'prov_id' => 10,
            'city_id' => 104,
        ]));
    }
}

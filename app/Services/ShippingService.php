<?php

namespace App\Services;

use App\Models\UserAddress;
use Illuminate\Support\Facades\Http;

class ShippingService
{
    private const MOCK_ORIGIN_CITY_ID = 104;

    public function getProvinces(): array
    {
        if ($this->shouldUseMockData()) {
            return $this->getMockProvinces();
        }

        try {
            $response = Http::withHeaders($this->apiHeaders())
                ->get('https://api.rajaongkir.com/starter/province');

            if ($response->successful() && isset($response['rajaongkir']['results'])) {
                return $response['rajaongkir']['results'];
            }
        } catch (\Throwable $e) {
            // Fall back to deterministic mock data when the provider is unavailable.
        }

        return $this->getMockProvinces();
    }

    public function getCitiesByProvince(int|string $provinceId): array
    {
        if ($this->shouldUseMockData()) {
            return $this->getMockCities((string) $provinceId);
        }

        try {
            $response = Http::withHeaders($this->apiHeaders())
                ->get('https://api.rajaongkir.com/starter/city?province=' . $provinceId);

            if ($response->successful() && isset($response['rajaongkir']['results'])) {
                return $response['rajaongkir']['results'];
            }
        } catch (\Throwable $e) {
            // Fall back to deterministic mock data when the provider is unavailable.
        }

        return $this->getMockCities((string) $provinceId);
    }

    public function resolveAddressLocation(int|string $provinceId, int|string $cityId): array
    {
        $provinceId = (string) $provinceId;
        $cityId = (string) $cityId;

        if ($this->shouldUseMockData()) {
            $cityData = collect($this->getMockCities($provinceId))->firstWhere('city_id', $cityId);

            return [
                'province' => $this->getProvinceName($provinceId),
                'city' => $cityData['city_name'] ?? ('City ' . $cityId),
            ];
        }

        try {
            $response = Http::withHeaders($this->apiHeaders())
                ->get('https://api.rajaongkir.com/starter/city?id=' . $cityId . '&province=' . $provinceId);

            if ($response->successful() && isset($response['rajaongkir']['results'])) {
                $data = $response['rajaongkir']['results'];

                return [
                    'province' => $data['province'] ?? $this->getProvinceName($provinceId),
                    'city' => $data['city_name'] ?? ('City ' . $cityId),
                ];
            }
        } catch (\Throwable $e) {
            // Fall back to deterministic mock data when the provider is unavailable.
        }

        return [
            'province' => $this->getProvinceName($provinceId),
            'city' => ('City ' . $cityId),
        ];
    }

    public function getShippingOptions(UserAddress $userAddress): array
    {
        if ($this->shouldUseMockData()) {
            return $this->getMockShippingOptions($userAddress);
        }

        try {
            $response = Http::withHeaders([
                'key' => $this->getApiKey(),
            ])->post('https://api.rajaongkir.com/starter/cost', [
                'origin' => 501,
                'originType' => 'city',
                'destination' => $userAddress->city_id,
                'destinationType' => 'city',
                'weight' => '1700',
                'courier' => 'jne',
            ]);

            if ($response->successful() && isset($response['rajaongkir']['results'])) {
                $shippingCosts = [];

                foreach ($response['rajaongkir']['results'] as $cost) {
                    foreach ($cost['costs'] as $value) {
                        $shippingCosts[] = [
                            'name' => strtoupper($cost['code']),
                            'type' => $value['service'],
                            'price' => (int) $value['cost'][0]['value'],
                        ];
                    }
                }

                if (!empty($shippingCosts)) {
                    return $shippingCosts;
                }
            }
        } catch (\Throwable $e) {
            // Fall back to deterministic mock data when the provider is unavailable.
        }

        return $this->getMockShippingOptions($userAddress);
    }

    private function shouldUseMockData(): bool
    {
        $provider = $this->getShippingProvider();

        if ((app()->environment('production') || config('app.env') === 'production') && $provider === 'mock') {
            throw new \RuntimeException('SHIPPING_PROVIDER=mock is only allowed for demo/local environments.');
        }

        if ($provider === 'mock') {
            return true;
        }

        $apiKey = $this->getApiKey();

        return blank($apiKey) || $apiKey === 'your_api_key_here';
    }

    private function getShippingProvider(): string
    {
        return strtolower((string) env('SHIPPING_PROVIDER', 'mock'));
    }

    private function getApiKey(): ?string
    {
        return env('RAJAONGKIR_API_KEY');
    }

    private function apiHeaders(): array
    {
        return [
            'key' => $this->getApiKey(),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    private function getProvinceName(string $provinceId): string
    {
        return collect($this->getMockProvinces())
            ->firstWhere('province_id', $provinceId)['province'] ?? 'Unknown Province';
    }

    private function getMockShippingOptions(UserAddress $userAddress): array
    {
        $zoneMultiplier = $this->resolveMockZoneMultiplier((int) $userAddress->prov_id);
        $distanceFee = $this->resolveDistanceFee((int) $userAddress->city_id);

        return [
            [
                'name' => 'JNE',
                'type' => 'REG',
                'price' => $this->roundedShippingPrice(12000, $zoneMultiplier, $distanceFee),
            ],
            [
                'name' => 'JNE',
                'type' => 'YES',
                'price' => $this->roundedShippingPrice(18000, $zoneMultiplier, $distanceFee),
            ],
            [
                'name' => 'SiCepat',
                'type' => 'REG',
                'price' => $this->roundedShippingPrice(12500, $zoneMultiplier, $distanceFee),
            ],
            [
                'name' => 'POS',
                'type' => 'KILAT',
                'price' => $this->roundedShippingPrice(10000, $zoneMultiplier, $distanceFee),
            ],
        ];
    }

    private function resolveMockZoneMultiplier(int $provId): float
    {
        if (in_array($provId, [5, 6, 9, 10, 11], true)) {
            return 1.0;
        }

        if (in_array($provId, [3, 17, 18, 26, 32, 33, 34], true)) {
            return 1.25;
        }

        if (in_array($provId, [1, 22, 23], true)) {
            return 1.45;
        }

        if (in_array($provId, [12, 13, 14, 15, 16], true)) {
            return 1.65;
        }

        if (in_array($provId, [19, 20, 24, 25, 27, 28, 29, 30, 31], true)) {
            return 1.95;
        }

        return 1.35;
    }

    private function resolveDistanceFee(int $cityId): int
    {
        return abs($cityId - self::MOCK_ORIGIN_CITY_ID) < 15 ? 0 : 2000;
    }

    private function roundedShippingPrice(int $basePrice, float $zoneMultiplier, int $distanceFee): int
    {
        $calculated = (int) round(($basePrice * $zoneMultiplier) + $distanceFee, -2);

        return (int) (round($calculated / 500) * 500);
    }

    private function getMockCities(string $provinceId): array
    {
        $cities = [
            '5' => [
                ['city_id' => '501', 'city_name' => 'Yogyakarta', 'type' => 'Kota'],
                ['city_id' => '502', 'city_name' => 'Sleman', 'type' => 'Kabupaten'],
                ['city_id' => '503', 'city_name' => 'Bantul', 'type' => 'Kabupaten'],
                ['city_id' => '504', 'city_name' => 'Gunung Kidul', 'type' => 'Kabupaten'],
                ['city_id' => '505', 'city_name' => 'Kulon Progo', 'type' => 'Kabupaten'],
            ],
            '6' => [
                ['city_id' => '151', 'city_name' => 'Jakarta Pusat', 'type' => 'Kota'],
                ['city_id' => '152', 'city_name' => 'Jakarta Utara', 'type' => 'Kota'],
                ['city_id' => '153', 'city_name' => 'Jakarta Barat', 'type' => 'Kota'],
                ['city_id' => '154', 'city_name' => 'Jakarta Selatan', 'type' => 'Kota'],
                ['city_id' => '155', 'city_name' => 'Jakarta Timur', 'type' => 'Kota'],
            ],
            '9' => [
                ['city_id' => '79', 'city_name' => 'Bandung', 'type' => 'Kota'],
                ['city_id' => '80', 'city_name' => 'Bogor', 'type' => 'Kota'],
                ['city_id' => '81', 'city_name' => 'Cirebon', 'type' => 'Kota'],
                ['city_id' => '82', 'city_name' => 'Bekasi', 'type' => 'Kota'],
                ['city_id' => '83', 'city_name' => 'Depok', 'type' => 'Kota'],
                ['city_id' => '84', 'city_name' => 'Sukabumi', 'type' => 'Kota'],
            ],
            '10' => [
                ['city_id' => '104', 'city_name' => 'Semarang', 'type' => 'Kota'],
                ['city_id' => '105', 'city_name' => 'Solo', 'type' => 'Kota'],
                ['city_id' => '106', 'city_name' => 'Pekalongan', 'type' => 'Kota'],
                ['city_id' => '107', 'city_name' => 'Tegal', 'type' => 'Kota'],
                ['city_id' => '108', 'city_name' => 'Salatiga', 'type' => 'Kota'],
            ],
            '11' => [
                ['city_id' => '444', 'city_name' => 'Surabaya', 'type' => 'Kota'],
                ['city_id' => '445', 'city_name' => 'Malang', 'type' => 'Kota'],
                ['city_id' => '446', 'city_name' => 'Sidoarjo', 'type' => 'Kabupaten'],
                ['city_id' => '447', 'city_name' => 'Gresik', 'type' => 'Kabupaten'],
                ['city_id' => '448', 'city_name' => 'Kediri', 'type' => 'Kota'],
            ],
            '3' => [
                ['city_id' => '164', 'city_name' => 'Tangerang', 'type' => 'Kota'],
                ['city_id' => '165', 'city_name' => 'Serang', 'type' => 'Kota'],
                ['city_id' => '166', 'city_name' => 'Cilegon', 'type' => 'Kota'],
            ],
        ];

        return $cities[$provinceId] ?? [
            ['city_id' => $provinceId . '01', 'city_name' => 'Kota Utama', 'type' => 'Kota'],
            ['city_id' => $provinceId . '02', 'city_name' => 'Kota Sekunder', 'type' => 'Kota'],
        ];
    }

    private function getMockProvinces(): array
    {
        return [
            ['province_id' => '1', 'province' => 'Bali'],
            ['province_id' => '2', 'province' => 'Bangka Belitung'],
            ['province_id' => '3', 'province' => 'Banten'],
            ['province_id' => '4', 'province' => 'Bengkulu'],
            ['province_id' => '5', 'province' => 'DI Yogyakarta'],
            ['province_id' => '6', 'province' => 'DKI Jakarta'],
            ['province_id' => '7', 'province' => 'Gorontalo'],
            ['province_id' => '8', 'province' => 'Jambi'],
            ['province_id' => '9', 'province' => 'Jawa Barat'],
            ['province_id' => '10', 'province' => 'Jawa Tengah'],
            ['province_id' => '11', 'province' => 'Jawa Timur'],
            ['province_id' => '12', 'province' => 'Kalimantan Barat'],
            ['province_id' => '13', 'province' => 'Kalimantan Selatan'],
            ['province_id' => '14', 'province' => 'Kalimantan Tengah'],
            ['province_id' => '15', 'province' => 'Kalimantan Timur'],
            ['province_id' => '16', 'province' => 'Kalimantan Utara'],
            ['province_id' => '17', 'province' => 'Kepulauan Riau'],
            ['province_id' => '18', 'province' => 'Lampung'],
            ['province_id' => '19', 'province' => 'Maluku'],
            ['province_id' => '20', 'province' => 'Maluku Utara'],
            ['province_id' => '21', 'province' => 'Nanggroe Aceh Darussalam'],
            ['province_id' => '22', 'province' => 'Nusa Tenggara Barat'],
            ['province_id' => '23', 'province' => 'Nusa Tenggara Timur'],
            ['province_id' => '24', 'province' => 'Papua'],
            ['province_id' => '25', 'province' => 'Papua Barat'],
            ['province_id' => '26', 'province' => 'Riau'],
            ['province_id' => '27', 'province' => 'Sulawesi Barat'],
            ['province_id' => '28', 'province' => 'Sulawesi Selatan'],
            ['province_id' => '29', 'province' => 'Sulawesi Tengah'],
            ['province_id' => '30', 'province' => 'Sulawesi Tenggara'],
            ['province_id' => '31', 'province' => 'Sulawesi Utara'],
            ['province_id' => '32', 'province' => 'Sumatera Barat'],
            ['province_id' => '33', 'province' => 'Sumatera Selatan'],
            ['province_id' => '34', 'province' => 'Sumatera Utara'],
        ];
    }
}

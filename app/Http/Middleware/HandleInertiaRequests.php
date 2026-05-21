<?php

namespace App\Http\Middleware;

use App\Helper\CartHelper;
use App\Http\Resources\CartResource;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;


class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $bannerGlobal = Banner::where('isActive', 1)->get();
        $categoryGlobal = Category::all();
        $brandGlobal = Brand::all();
        $storeSettings = StoreSetting::firstOrCreate([], [
            'store_name' => 'TB. Bangun Persada',
            'store_description' => 'Toko material bangunan untuk kebutuhan proyek rumah, renovasi, dan konstruksi di area Demak.',
            'address' => 'Jatengland Industrial Park Sayung, Batu, Demak, Jawa Tengah 59563',
            'google_maps_url' => 'https://www.google.com/maps/place/TB.+Bangun+Persada/@-6.9270331,110.5525637,17z',
        ]);

        $cartBelongsToRequestUser = 0;
        if ($request->user()) {
            $cartBelongsToRequestUser = Cart::whereUserId($request->user()->id)->whereNull('paid_at')->count();
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => fn () => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'role' => $request->user()->role,
                    'isAdmin' => (bool) $request->user()->isAdmin,
                    'email_verified_at' => $request->user()->email_verified_at,
                ] : null,
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'cart' => new CartResource(CartHelper::getProductsAndCartItems()),
            'carts_global_count' => $request->user() ? $cartBelongsToRequestUser : '',
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
                'info' => fn () => $request->session()->get('info')
            ],
            'banner_global' => $bannerGlobal,
            'category_global' => $categoryGlobal,
            'brand_global' => $brandGlobal,
            'store_settings' => $storeSettings,
            'canLogin' => app('router')->has('login'),
            'canRegister' => app('router')->has('register'),
        ];
    }
}

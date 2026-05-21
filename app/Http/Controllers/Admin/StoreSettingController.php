<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use App\Support\WebpImageUploader;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoreSettingController extends Controller
{
    private function defaultSettings(): array
    {
        return [
            'store_name' => 'TB. Bangun Persada',
            'store_description' => 'Toko material bangunan untuk kebutuhan proyek rumah, renovasi, dan konstruksi di area Demak.',
            'contact_email' => null,
            'contact_phone' => null,
            'contact_whatsapp' => null,
            'address' => 'Jatengland Industrial Park Sayung, Batu, Demak, Jawa Tengah 59563',
            'google_maps_url' => 'https://maps.app.goo.gl/JoYzbZAwjvtzvdEg7',
            'facebook_url' => null,
            'instagram_url' => null,
            'twitter_url' => null,
        ];
    }

    public function index()
    {
        $settings = StoreSetting::firstOrCreate([], $this->defaultSettings());

        return Inertia::render('Admin/Setting/Index', [
            'settings' => $settings
        ]);
    }

    public function update(Request $request)
    {
        $settings = StoreSetting::firstOrCreate([], $this->defaultSettings());
        
        $data = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'google_maps_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'store_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('store_logo')) {
            if ($settings->store_logo) {
                $existingLogo = public_path('storage/' . ltrim($settings->store_logo, '/'));

                if (is_file($existingLogo)) {
                    unlink($existingLogo);
                }
            }

            $data['store_logo'] = ltrim(WebpImageUploader::store($request->file('store_logo'), 'storage/settings'), '/');
            $data['store_logo'] = preg_replace('#^storage/#', '', $data['store_logo']);
        }

        $settings->update($data);

        return back()->with('success', 'Pengaturan toko berhasil diperbarui');
    }
}

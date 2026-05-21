<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Support\WebpImageUploader;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;

class BannerController extends Controller
{
    private const IMAGE_RULES = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $banners = Banner::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return Inertia::render('Admin/Banner/Index',[
            'banners' => $banners,
            'search'=> $request->search
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'isActive' => ['nullable', 'boolean'],
            'image' => self::IMAGE_RULES,
        ]);

        $banner = new Banner;
        $banner->name = $title = $validated['name'];
        $banner->slug = str($title)->slug();
        $banner->isActive = $request->boolean('isActive');
        if ($request->hasFile('image')) {
            $banner->image = WebpImageUploader::store($request->file('image'), 'banner_image');
        }
        if($banner->save()){
            //check if product has images upload
            Cache::forget('banner_global');
            return redirect()->route('admin.banner.index')->with('success', 'Product banner successfully.');
        }else{
            return redirect()->back()->with('errors', 'Failed create product');
        }
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'isActive' => ['nullable', 'boolean'],
            'image' => self::IMAGE_RULES,
        ]);

        $banner = Banner::findOrFail($id);
        $banner->name = $title = $validated['name'];
        $banner->slug = str($title)->slug();
        $banner->isActive = $request->boolean('isActive');
        if ($request->hasFile('image')) {
            $banner->image = WebpImageUploader::store($request->file('image'), 'banner_image');
        }

        $banner->update();
        Cache::forget('banner_global');
        return redirect()->route('admin.banner.index')->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        if($banner){
            $filePath = public_path(ltrim($banner->image, '/'));
            if (is_file($filePath)) {
                unlink($filePath);
            }

            $banner->delete();
        }
        Cache::forget('banner_global');
        return redirect()->route('admin.banner.index')->with('success', 'Banner deleted successfully.');
    }

    public function deleteImage($slug){
        $image = Banner::where('slug', $slug)->first();
        if($image){
            $filePath = public_path(ltrim($image->image, '/'));
//            dd(is_file($filePath));
            if (is_file($filePath)) {
                unlink($filePath);
            }

            $image->image = '';
            $image->save();
            return redirect()->route('admin.banner.index')->with('success', 'Image deleted successfully');
        }else{
            return redirect()->back()->with('errors', 'Image not found');

        }
    }
}

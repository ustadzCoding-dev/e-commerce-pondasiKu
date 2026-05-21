<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Support\WebpImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class BrandController extends Controller
{
    private const IMAGE_RULES = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Brand/Index',[
            'brands' => $brands,
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
            'image' => self::IMAGE_RULES,
        ]);

        $brand = new Brand;
        $brand->name = $title = $validated['name'];
        $brand->slug = str($title)->slug();
        if ($request->hasFile('image')) {
            $brand->image = WebpImageUploader::store($request->file('image'), 'brand_image');
        }
        if($brand->save()){
            //check if product has images upload
            Cache::forget('brand_global');
            return redirect()->route('admin.brand.index')->with('success', 'Brand successfully added.');
        }else{
            return redirect()->back()->with('errors', 'Failed create category');
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
            'image' => self::IMAGE_RULES,
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $title = $validated['name'];
        $brand->slug = str($title)->slug();
        if ($request->hasFile('image')) {
            $brand->image = WebpImageUploader::store($request->file('image'), 'brand_image');
        }

        $brand->update();
        Cache::forget('brand_global');
        return redirect()->route('admin.brand.index')->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        if($brand){
            $filePath = public_path(ltrim($brand->image, '/'));
            if (is_file($filePath)) {
                unlink($filePath);
            }

            $brand->delete();
        }
        Cache::forget('category_global');
        return redirect()->route('admin.brand.index')->with('success', 'Brand deleted successfully.');
    }

    public function deleteImage($slug){
        $image = Brand::where('slug', $slug)->first();
        if($image){
            $filePath = public_path(ltrim($image->image, '/'));
            if (is_file($filePath)) {
                unlink($filePath);
            }

            $image->image = '';
            $image->save();
            return redirect()->route('admin.brand.index')->with('success', 'Image deleted successfully');
        }else{
            return redirect()->back()->with('errors', 'Image not found');

        }
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->where('published', 1)
            ->with(['category', 'brand', 'product_images']);
        $filterProducts = $products->filtered()
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::all();
        $brands = Brand::all();

        return Inertia::render('User/Product/Index',[
            'products' => $filterProducts,
            'categories' => $categories,
            'brands' => $brands,
            'selectedBrands' => collect($request->input('brands', []))->map(fn($id) => (int)$id)->toArray(),
            'selectedCategories' => collect($request->input('categories', []))->map(fn($id) => (int)$id)->toArray(),
            'selectedPrices' => [
                'from' => $request->input('prices.from', 0),
                'to' => $request->input('prices.to', 1000000),
            ],
            'search' => $request->search
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = Product::with('category', 'brand', 'product_images')
            ->where('published', 1)
            ->where('id', $product->id)
            ->firstOrFail();

        // Algoritma Rekomendasi Cross-Selling (Market Basket Analysis sederhana)
        $relatedProducts = Product::with('brand', 'product_images')
            ->where('published', 1)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return Inertia::render('User/Product/Show',[
            'product' => $product,
            'related_products' => $relatedProducts,
        ]);
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
}

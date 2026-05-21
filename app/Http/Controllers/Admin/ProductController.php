<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductTableResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Support\WebpImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductController extends Controller
{
    private const IMAGE_RULES = ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];

    private function productRules(bool $isUpdate = false): array
    {
        return [
            'title' => [$isUpdate ? 'sometimes' : 'required', 'string', 'max:255'],
            'price' => [$isUpdate ? 'sometimes' : 'required', 'numeric', 'min:0'],
            'quantity' => [$isUpdate ? 'sometimes' : 'required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'category_id' => [$isUpdate ? 'sometimes' : 'required', 'exists:categories,id'],
            'brand_id' => [$isUpdate ? 'sometimes' : 'required', 'exists:brands,id'],
            'unit' => ['nullable', 'string', 'max:20'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'min_stock' => ['nullable', 'integer', 'min:0'],
            'published' => ['nullable', 'boolean'],
            'product_images' => ['nullable', 'array', 'max:8'],
            'product_images.*' => self::IMAGE_RULES,
        ];
    }

    private function storeProductImageFile($image): string
    {
        return ltrim(WebpImageUploader::store($image, 'product_images'), '/');
    }

    private function deleteProductImageFile(string $imagePath): void
    {
        $filePath = public_path(ltrim($imagePath, '/'));

        if (is_file($filePath)) {
            unlink($filePath);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::all();
        $categories = Category::all();

        // Calculate stats for ALL products (not just current page)
        $stats = [
            'total' => Product::count(),
            'tersedia' => DB::table('products')->where('inStock', 1)->whereRaw('quantity > min_stock')->count(),
            'stok_terbatas' => DB::table('products')->where('inStock', 1)->whereRaw('quantity <= min_stock')->where('quantity', '>', 0)->count(),
            'stok_habis' => DB::table('products')->where(function($q) { $q->where('inStock', 0)->orWhere('quantity', '<=', 0); })->count(),
            'dipublikasi' => Product::where('published', 1)->count(),
        ];

        $products = Product::query()
            ->with(['category', 'brand', 'product_images'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('price', 'like', '%' . $search . '%')
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('brand', function ($brandQuery) use ($search) {
                            $brandQuery->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Product/Index',[
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
            'search'=> $request->search,
            'stats' => $stats,
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->productRules());

        $product = new Product;
        $product->title = $title = $validated['title'];
        $product->slug = str($title)->slug();
        $product->price = $validated['price'];
        $product->quantity = $validated['quantity'];
        $product->description = $validated['description'] ?? null;
        $product->category_id = $validated['category_id'];
        $product->brand_id = $validated['brand_id'];
        // PondasiKu: Material fields
        $product->unit = $validated['unit'] ?? 'pcs';
        $product->weight = $validated['weight'] ?? 0;
        $product->min_stock = $validated['min_stock'] ?? 10;
        $product->inStock = $validated['quantity'] > 0 ? 1 : 0;
        $product->published = $request->has('published') ? $request->boolean('published') : true;

        if($product->save()){
            //check if product has images upload

            if ($request->hasFile('product_images')) {
                $productImages = $request->file('product_images');
                foreach ($productImages as $image) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $this->storeProductImageFile($image),
                    ]);
                }
            }

            return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
        }else{
            return redirect()->back()->with('errors', 'Failed create product');
        }

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate($this->productRules(true));
        $product = Product::findOrFail($id);

//         dd($request->all());
        $product->title = $validated['title'] ?? $product->title;
        $product->slug = str($product->title)->slug();
        $product->price = $validated['price'] ?? $product->price;
        $product->quantity = $validated['quantity'] ?? $product->quantity;
        $product->description = $validated['description'] ?? $product->description;
        $product->category_id = $validated['category_id'] ?? $product->category_id;
        $product->brand_id = $validated['brand_id'] ?? $product->brand_id;
        // PondasiKu: Material fields
        $product->unit = $validated['unit'] ?? $product->unit ?? 'pcs';
        $product->weight = $validated['weight'] ?? $product->weight ?? 0;
        $product->min_stock = $validated['min_stock'] ?? $product->min_stock ?? 10;
        $product->inStock = $product->quantity > 0 ? 1 : 0;
        $product->published = $request->has('published') ? $request->boolean('published') : $product->published;
        // Check if product images were uploaded
        if ($request->hasFile('product_images')) {
            $productImages = $request->file('product_images');
            foreach ($productImages as $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $this->storeProductImageFile($image),
                ]);
            }
        }
        $product->update();
        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if($product){
            $image = ProductImage::where('product_id', $id)->get();
            foreach ($image as $img){
                $this->deleteProductImageFile($img->image);
                $img->delete();
            }

            $product->delete();
        }
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
    }

    public function deleteImage($id){
        $image = ProductImage::find($id);
        if($image){
            $this->deleteProductImageFile($image->image);
            $image->delete();
            return redirect()->route('admin.product.index')->with('success', 'Image deleted successfully');
        }else{
            return redirect()->back()->with('errors', 'Image not found');

        }
    }
}

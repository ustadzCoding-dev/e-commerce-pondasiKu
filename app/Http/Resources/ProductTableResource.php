<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'min_stock' => $this->min_stock,
            'is_low_stock' => $this->is_low_stock,
            'inStock' => $this->inStock,
            'published' => (bool) $this->published,
            'description' => $this->description,
            'category' => [
                'name' => $this->category->name,
//                'url' => route('category.show', $this->category),
            ],
            'brand' => [
                'name' => $this->brand->name,
//                'url' => route('category.show', $this->category),
            ],
        ];
    }
}

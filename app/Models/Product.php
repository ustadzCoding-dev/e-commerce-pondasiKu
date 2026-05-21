<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    protected $appends = [
        'is_low_stock',
        'unit_display',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function product_images(){
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function cartItem(){
        return $this->hasMany(Cart::class, 'product_id');
    }

    public function orderItem(){
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    // Accessor untuk display unit
    public function getUnitDisplayAttribute(): string
    {
        return match($this->unit) {
            'pcs' => 'pcs',
            'sak' => 'sak',
            'kg' => 'kg',
            'm' => 'm',
            'm2' => 'm²',
            'm3' => 'm³',
            'lbr' => 'lembar',
            'btg' => 'batang',
            default => $this->unit ?? 'pcs',
        };
    }

    // Check if stock is low (but not out of stock)
    public function getIsLowStockAttribute(): bool
    {
        return $this->quantity > 0 && $this->quantity <= $this->min_stock;
    }

    //filter logic for price or categories or brands

    public function scopeFiltered(Builder $query)  {
        $query
            ->when(request('brands'), function (Builder $q)  {
                $q->whereIn('brand_id', request('brands'));
            })
            ->when(request('categories'), function (Builder $q)  {
                $q->whereIn('category_id', request('categories'));
            })
            ->when(request('prices'), function(Builder $q)  {
                $q->whereBetween('price', [
                    request('prices.from', 0),
                    request('prices.to', 999999999), // increased max price limit
                ]);
            });
    }
}

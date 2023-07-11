<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')
            ->with('category', 'subCategory', 'variant', 'variantOption', 'segment', 'pack');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderItems()
    {
        return $this->belongsTo(OrderItem::class, 'inventory_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comboItems()
    {
        return $this->belongsTo(ComboItem::class, 'inventory_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventoryVariants()
    {
        return $this->hasMany(InventoryVariant::class, 'inventory_id', 'id')->with('variant', 'variantOption');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventoryImages()
    {
        return $this->hasMany(InventoryImage::class, 'inventory_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'inventory_id', 'id');
    }
}

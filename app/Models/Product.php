<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Variant;
use App\Models\VariantOption;
use App\Models\Segment;
use App\Models\PackType;
use App\Models\ProductImage;
use App\Models\ProductLifestyle;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    public $timestamps = false;

    /* public function variant()
    {
      return $this->belongsTo(Variant::class)->select(['id','name','status']);
    }

    public function variantOption()
    {
      return $this->belongsTo(VariantOption::class)->select(['id','name','status']);
    }
    public function segment()
    {
      return $this->belongsTo(Segment::class)->select(['id','name','status']);
    }
    public function pack()
    {
      return $this->belongsTo(PackType::class)->select(['id','name','status']);
    } */
    /* public function category()
    {
      return $this->belongsTo(Category::class)->select(['id','name','image','status']);
    } */
    public function category()
    {
      return $this->belongsTo(Category::class);
    }
    public function sub_category()
    {
      return $this->belongsTo(SubCategory::class);
    }
    public function variant()
    {
      return $this->belongsTo(Variant::class);
    }

    public function variantOption()
    {
      return $this->belongsTo(VariantOption::class);
    }
    public function segment()
    {
      return $this->belongsTo(Segment::class);
    }
    public function pack()
    {
      return $this->belongsTo(PackType::class);
    }

    public function productmultiimage()
    {
      //return $this->hasMany(ProductImage::class);
      return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function productlifestyle()
    {
      return $this->hasMany(ProductLifestyle::class);
    }

    public function subCategory()
    {
      return $this->belongsTo(SubCategory::class)->select(['id','name','image','status']);
    }


    public function productImages()
    {
      return $this->hasMany(ProductImage::class)->select(['id','product_id','image','status']);
    }



}

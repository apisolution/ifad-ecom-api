<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    public $timestamps = false;


    public function blog_category()
    {
      return $this->belongsTo(BlogCategory::class);
    }
}

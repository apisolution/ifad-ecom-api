<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;

class CategoryController extends Controller
{
    public function allSubCategorylist(){
        $sub_categories=Category::with('subCategories')->get();
        return response()->json($sub_categories);
    }
}

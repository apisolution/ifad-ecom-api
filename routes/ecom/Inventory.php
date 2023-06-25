<?php

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 *
 */
Route::get('/inventories', function (Request $request) {
    try {
        return Inventory::with(['product', 'inventoryVariants', 'inventoryImages'])
            ->groupBy('product_id')
            ->paginate();
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

/**
 *
 */
Route::get('/inventories/categories/{categoryId}', function (Request $request, $categoryId) {
    try {
        return Inventory::with(['product', 'inventoryVariants', 'inventoryImages'])
            ->whereHas('product', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->groupBy('product_id')
            ->paginate();
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

/**
 *
 */
Route::get('/inventories/subCategories/{subCategoryId}', function (Request $request, $subCategoryId) {
    try {
        return Inventory::with(['product', 'inventoryVariants', 'inventoryImages'])
            ->whereHas('product', function ($query) use ($subCategoryId) {
                $query->where('sub_category_id', $subCategoryId);
            })
            ->groupBy('product_id')
            ->paginate();
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

/**
 *
 */
Route::get('/inventories/{id}/show', function ($id) {
    try {
        return Inventory::with(['product', 'inventoryVariants', 'inventoryImages'])->findOrFail($id);
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

/**
 *
 */
Route::get('/inventories/search', function (Request $request) {
    try {
        $keyword = $request->keyword;

        $query = Inventory::query();
        $query->groupBy('product_id');
        $query->with(['product', 'inventoryVariants', 'inventoryImages']);
        $query->whereHas('product', function ($query) use ($keyword) {
            $query->where('title', 'LIKE', "%" . $keyword . "%");
        });

        return $query->paginate();
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});
<?php

use App\Models\Combo;
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
Route::get('/combos', function (Request $request) {
    try {
        $query = Combo::query();
        $query->with('comboCategory', 'comboItems', 'comboImages');

        $query->when($request->order_column && $request->order_by, function ($q) use ($request) {
            $q->orderBy($request->order_column, $request->order_by);
        });

        $query->when($request->limit, function ($q) use ($request) {
            $q->limit($request->limit);
        });

        return $query->paginate();
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

/**
 *
 */
Route::get('/combos/{id}/show', function ($id) {
    try {
        return Combo::with(['comboCategory', 'comboItems', 'comboImages', 'reviews'])->findOrFail($id);
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

/**
 *
 */
Route::get('/combos/combo-categories/{comboCategoryId}', function (Request $request, $comboCategoryId) {
    try {
        return Combo::with(['comboCategory', 'comboItems', 'comboImages'])
            ->where('combo_category_id', $comboCategoryId)
            ->paginate();
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

/**
 *
 */
Route::get('/combos/search', function (Request $request) {
    try {
        $keyword = $request->keyword;

        $query = Combo::query();
        $query->with(['comboCategory', 'comboItems', 'comboImages']);
        $query->where('title', 'LIKE', "%" . $keyword . "%");

        return $query->paginate();
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

<?php

use App\Models\SubCategory;
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
Route::get('/sub-categories', function (Request $request) {
    try {
        return SubCategory::paginate();
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

/**
 *
 */
Route::get('/sub-categories/{id}', function (Request $request, $id) {
    try {
        return SubCategory::findOrFail($id);
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

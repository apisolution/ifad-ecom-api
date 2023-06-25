<?php

use App\Models\ComboCategory;
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
Route::get('/combo-categories', function (Request $request) {
    try {
        return ComboCategory::paginate();
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

/**
 *
 */
Route::get('/combo-categories/{id}', function (Request $request, $id) {
    try {
        return ComboCategory::findOrFail($id);
    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }
});

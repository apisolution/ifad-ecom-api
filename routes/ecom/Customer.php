<?php

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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
Route::group(['middleware' => 'isCustomer'], function () {

    /**
     *
     */
    Route::get('/customers', function () {
        try {
            return Customer::paginate();
        } catch (Exception $exception) {
            return make_error_response($exception->getMessage());
        }
    });

    /**
     *
     */
    Route::get('/customers/{id}/show', function ($id) {
        try {
            return Customer::findOrFail($id);
        } catch (Exception $exception) {
            return make_error_response($exception->getMessage());
        }
    });

    /**
     *
     */
    Route::put('/customers/{id}', function (Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'address' => ['required'],
                'date_of_birth' => ['nullable'],
                'gender' => ['nullable'],
                'phone_number' => ['required'],
            ]);

            if ($validator->fails()) {
                return make_validation_error_response($validator->getMessageBag());
            }

            $customer = Customer::findOrFail($id);
            $customer->name = $request->name;
            $customer->address = $request->address;
            $customer->date_of_birth = $request->date_of_birth;
            $customer->gender = $request->gender;
            $customer->phone_number = $request->phone_number;
            $customer->save();

            return make_success_response("Record saved successfully.");
        } catch (Exception $exception) {
            return make_error_response($exception->getMessage());
        }
    });

    /**
     *
     */
    Route::get('/customers/addresses', function () {
        try {
            return Address::where('customer_id', auth_customer('id'))->paginate();
        } catch (Exception $exception) {
            return make_error_response($exception->getMessage());
        }
    });
});

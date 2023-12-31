<?php

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
    Route::get('/addresses', function () {
        try {
            return Address::where('customer_id', auth_customer('id'))->paginate();
        } catch (Exception $exception) {
            return make_error_response($exception->getMessage());
        }
    });

    /**
     *
     */
    Route::get('/addresses/{id}/show', function ($id) {
        try {
            return Address::where('customer_id', auth_customer('id'))->findOrFail($id);
        } catch (Exception $exception) {
            return make_error_response($exception->getMessage());
        }
    });

    /**
     *
     */
    Route::post('/addresses', function (Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'title' => ['required', Rule::unique('addresses', 'title')],
                'address_line_1' => ['required'],
                'address_line_2' => ['nullable'],
                'division_id' => ['required', 'numeric'],
                'district_id' => ['required', 'numeric'],
                'upazila_id' => ['required', 'numeric'],
                'postcode' => ['required'],
                'phone' => ['required'],
            ]);

            if ($validator->fails()) {
                return make_validation_error_response($validator->getMessageBag());
            }

            $address = new Address();
            $address->title = $request->title;
            $address->address_line_1 = $request->address_line_1;
            $address->address_line_2 = $request->address_line_2;
            $address->division_id = $request->division_id;
            $address->district_id = $request->district_id;
            $address->upazila_id = $request->upazila_id;
            $address->postcode = $request->postcode;
            $address->phone = $request->phone;
            $address->customer_id = auth_customer('id');
            $address->is_default_billing = null;
            $address->is_default_shipping = null;
            $address->save();

            return make_success_response("Record saved successfully.");
        } catch (Exception $exception) {
            return make_error_response($exception->getMessage());
        }
    });

    /**
     *
     */
    Route::put('/addresses/{id}', function (Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), [
                'title' => ['required', Rule::unique('addresses', 'title')->ignore($id, 'id')],
                'address_line_1' => ['required'],
                'address_line_2' => ['nullable'],
                'division_id' => ['required', 'numeric'],
                'district_id' => ['required', 'numeric'],
                'upazila_id' => ['required', 'numeric'],
                'postcode' => ['required'],
                'phone' => ['required'],
            ]);

            if ($validator->fails()) {
                return make_validation_error_response($validator->getMessageBag());
            }

            $address = Address::findOrFail($id);
            $address->title = $request->title;
            $address->address_line_1 = $request->address_line_1;
            $address->address_line_2 = $request->address_line_2;
            $address->division_id = $request->division_id;
            $address->district_id = $request->district_id;
            $address->upazila_id = $request->upazila_id;
            $address->postcode = $request->postcode;
            $address->phone = $request->phone;
            $address->update();

            return make_success_response("Record saved successfully.");
        } catch (Exception $exception) {
            return make_error_response($exception->getMessage());
        }
    });

    /**
     *
     */
    Route::delete('/addresses/{id}', function ($id) {
        try {
            $address = Address::findOrFail($id);

            if ($address) {
                $address->delete();
            }

            return make_success_response("Record deleted successfully.");
        } catch (Exception $exception) {
            return make_error_response($exception->getMessage());
        }
    });

    /**
     *
     */
    Route::put('/addresses/{id}/default-shipping', function (Request $request, $id) {
        try {

            Address::get()->map(function ($address) {
                $address->is_default_shipping = Null;
                $address->update();
            });

            $address = Address::findOrFail($id);
            $address->is_default_shipping = '1';
            $address->update();

            return make_success_response("Record updated successfully.");
        } catch (Exception $exception) {
            return make_error_response($exception->getMessage());
        }
    });

    /**
     *
     */
    Route::put('/addresses/{id}/default-billing', function (Request $request, $id) {
        try {

            Address::get()->map(function ($address) {
                $address->is_default_billing = Null;
                $address->update();
            });

            $address = Address::findOrFail($id);
            $address->is_default_billing = '1';
            $address->update();

            return make_success_response("Record updated successfully.");
        } catch (Exception $exception) {
            return make_error_response($exception->getMessage());
        }
    });
});

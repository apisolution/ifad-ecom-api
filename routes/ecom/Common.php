<?php

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

/**
 *
 */
Route::post('/send-contact-form', function (Request $request) {
    try {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'subject' => ['required'],
            'message' => ['required']
        ]);

        if ($validator->fails()) {
            return make_validation_error_response($validator->getMessageBag());
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ];

        Mail::send(['text' => 'Email.send_contact_form'], $data, function ($message) use ($data) {
            $message->to(config('mail.contact_form_recipient_email'));
            $message->from($data["email"], $data["name"]);
            $message->subject($data["subject"]);
        });

    } catch (Exception $exception) {
        return make_error_response($exception->getMessage());
    }

    return make_success_response("Email sent successfully.");
});

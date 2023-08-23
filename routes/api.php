<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\logoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserVerifyController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Ticket\TicketController;
use App\Http\Controllers\User\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('home' , [UserController::class , 'home']);

Route::post('user-verify' , [UserVerifyController::class , 'userVerify']);
Route::post('user-otp-verify' , [UserVerifyController::class , 'otpVerify']);
Route::post('user-register' , [RegisterController::class , 'register']);
Route::post('user-login' , [LoginController::class , 'login']);
Route::post('user-reset-password' , [ResetPasswordController::class , 'resetVerify']);
Route::post('user-reset-otp-verify' , [ResetPasswordController::class , 'resetOtpVerify']);
Route::post('user-new-password' , [ResetPasswordController::class , 'newPassword']);
Route::get('user-logout/{user_id}' , [logoutController::class , 'logout']);
Route::post('change-password/{id}' , [UserController::class , 'changePassword']);
Route::post('edit-profile/{id}' , [UserController::class , 'editProfile']);
Route::post('verify-edit-profile/{id}' , [UserController::class , 'editVerify']);
Route::get('remove-image/{id}' , [UserController::class , 'removeImage']);
Route::post('delete-account/{id}' , [UserController::class , 'deleteAccount']);



Route::get('cities' , [UserController::class , 'route']);
Route::get('schedules' , [UserController::class , 'routeResult']);




Route::get('categories' , [ReportController::class , 'reportCategory']);
Route::post('add-report' , [ReportController::class , 'addCategory']);
Route::get('user-report/{user_id}/{status}' , [ReportController::class , 'userReport']);
Route::get('close-ticket/{ticket_id}' , [ReportController::class , 'closeTicket']);
Route::post('send-message' , [ReportController::class , 'sendMessage']);
Route::get('conversation/{channel}' , [ReportController::class , 'conversation']);


Route::get('seat/{bus_id}/{route_id}' , [TicketController::class , 'seat']);
Route::get('user-tickets/{user_id}' , [TicketController::class , 'myTickets']);

Route::get('faq' , [UserController::class , 'faq']);  
Route::get('notifications/{user_id}' , [UserController::class , 'getNotification']);  
Route::get('read-notification/{not_id}' , [UserController::class , 'readNotification']);  

Route::get('notification-detail/{id}' , [UserController::class , 'notificationDetail']);  




Route::post('make-payment',[PaymentController::class,'makePayment']);


















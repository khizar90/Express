<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\ReportController;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/insert', function () {
    $user = new Admin();
    $user->name = 'Kevin Anderson';
    $user->username = 'admin';
    $user->email = 'admin@admin.com';
    $user->password = Hash::make('qweqwe');
    $user->save();
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('login');
    })->name('loginPage');

    Route::post('login', [AdminLoginController::class, 'login'])->name('login');
});

Route::prefix('dashboard')->middleware(['auth'])->name('dashboard-')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('home');
    Route::get('bus', [AdminController::class, 'viewBus'])->name('view-bus');
    Route::post('add-bus', [AdminController::class, 'addBus'])->name('add-bus');
    Route::post('edit-bus/{bus_id}', [AdminController::class, 'editBus'])->name('edit-bus');
    Route::get('delete-bus/{bus_id}', [AdminController::class, 'deleteBus'])->name('delete-bus');

    Route::get('cities', [AdminController::class, 'city'])->name('cities');
    Route::post('add-city', [AdminController::class, 'addCity'])->name('add-city');
    Route::post('edit-city/{city_id}', [AdminController::class, 'editCity'])->name('edit-city');
    Route::post('edit-city/{city_id}', [AdminController::class, 'editCity'])->name('edit-city');
    Route::get('delete-city/{city_id}', [AdminController::class, 'deleteCity'])->name('delete-city');

    Route::get('routes', [AdminController::class, 'route'])->name('routes');
    Route::post('add-route', [AdminController::class, 'addRoute'])->name('add-route');
    Route::post('edit-route/{route_id}', [AdminController::class, 'editRoute'])->name('edit-route');
    Route::get('delete-route/{route_id}', [AdminController::class, 'deleteRoute'])->name('delete-route');

    Route::get('schedules', [AdminController::class, 'schedules'])->name('schedules');
    Route::get('schedule-status/{id}', [AdminController::class, 'scheduleStatus'])->name('schedule-status');
    Route::post('add-schedule', [AdminController::class, 'addSchedule'])->name('add-schedule');
    Route::get('schedule-detail/{id}', [AdminController::class, 'scheduleDetail'])->name('schedule-detail');
    Route::post('schedule-edit/{id}', [AdminController::class, 'scheduleEdit'])->name('schedule-edit');
    Route::get('schedule-delete/{id}', [AdminController::class, 'scheduleDelete'])->name('schedule-delete');

    Route::get('bus-images', [AdminController::class, 'busImage'])->name('bus-images');
    Route::post('add-bus-images', [AdminController::class, 'addBusImage'])->name('add-bus-images');
    Route::get('delete-bus-image/{id}', [AdminController::class, 'deleteBusImage'])->name('delete-bus-image');


    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::get('users/export', [AdminController::class, 'exportCSV'])->name('users-export-csv');
    Route::post('add-user', [AdminController::class, 'addUser'])->name('add-user');
    Route::get('delete-user/{id}', [AdminController::class, 'deleteUser'])->name('delete-user');



    Route::get('faqs', [AdminController::class, 'faqs'])->name('faqs');
    Route::post('add-faq', [AdminController::class, 'addFaq'])->name('add-faq');
    Route::get('delete-faq/{id}', [AdminController::class, 'deleteFaq'])->name('delete-faq');

    Route::get('account', [AdminController::class, 'account'])->name('account');
    Route::post('account-update', [AdminController::class, 'accountUpdate'])->name('account-update');

    Route::get('account-security', [AdminController::class, 'accountSecurity'])->name('account-security');



    Route::get('report/{status}', [ReportController::class, 'report'])->name('report');
    Route::get('close-report/{id}', [ReportController::class, 'closeReport'])->name('close-report');
    Route::get('messages/{channel}', [ReportController::class, 'messages'])->name('messages');
    Route::post('send-message', [ReportController::class, 'sendMessage'])->name('send-message');

    Route::get('category', [AdminController::class, 'getCategory'])->name('category');
    Route::get('delete-category/{id}', [AdminController::class, 'deleteCategory'])->name('delete-category');
    Route::post('add-category', [AdminController::class, 'addCategory'])->name('add-category');



    Route::post('change-password', [Admincontroller::class, 'changePassword'])->name('change-password');


    Route::get('get-logout', [AdminLoginController::class, 'getLogout'])->name('get-logout');
    Route::get('logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Route::get('my-form','Admincontroller@myform');
    // Route::get('my-form', [Admincontroller::class, 'myform'])->name('myform');
    // Route::post('my-form', [Admincontroller::class, 'myformPost'])->name('my.form');

    // Route::post('my-form','Admincontroller@myformPost')->name('my.form');
    
});
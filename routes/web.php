<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [FileController::class, 'index'])->name('file.index');
// routes/web.php
// Route::get('/password', 'ForgotPasswordController@show')->name('password.show');
// // Route::get('/login', 'LoginController@show')->name('login.show');

// Route::get('/forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('/forgot-password', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

// Route::get('/reset-password/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
// Route::post('/reset-password', 'ResetPasswordController@reset');
// Auth::routes();


Route::post('/upload', [FileController::class, 'upload'])->name('file.upload');
Route::get('/download/{id}', [FileController::class, 'download'])->name('file.download');
Route::post('/decrypt', [FileController::class, 'decrypt'])->name('file.decrypt');
Route::delete('/delete/{id}', [FileController::class, 'delete'])->name('file.delete');

Route::group(['namespace' => 'App\Http\Controllers'], function() {
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('file.index');
        } else {
            return redirect()->route('login.show');
        }
    })->name('home');

    Route::get('/file', [FileController::class, 'index'])->name('file.index');


    // Route::get('/home', function () {
    //     if (Auth::check()) {
    //         return redirect()->route('file.index');
    //     } else {
    //         return redirect()->route('login.show');
    //     }
    // })->name('home');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        Route::get('/password', 'ForgotPasswordController@show')->name('password.show');
        Route::post('/password', 'ForgotPasswordController@password')->name('password.perform');

        Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

        Route::get('/password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        // Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
        // Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        // Route::post('/password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

        Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
        Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');

        /**
         *
         *
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});

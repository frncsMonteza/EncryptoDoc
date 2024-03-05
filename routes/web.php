<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

Route::post('/upload', [FileController::class, 'upload'])->name('file.upload');
Route::get('/download/{id}', [FileController::class, 'download'])->name('file.download');
Route::post('/decrypt', [FileController::class, 'decrypt'])->name('file.decrypt');
Route::delete('/delete/{id}', [FileController::class, 'delete'])->name('file.delete');

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', function () {
        return Auth::check() ? redirect()->route('file.index') : redirect()->route('login');
    })->name('home');

    Route::group(['middleware' => ['guest']], function () {
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        Route::get('/password', 'ForgotPasswordController@show')->name('password.show');
        Route::post('/password', 'ForgotPasswordController@password')->name('password.perform');

        Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

        Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

        Route::get('/login', 'LoginController@show')->name('login');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/file', [FileController::class, 'index'])->name('file.index');
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});

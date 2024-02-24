<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

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
Route::post('/upload', [FileController::class, 'upload'])->name('file.upload');
Route::get('/download/{id}', [FileController::class, 'download'])->name('file.download');


Route::post('/decrypt', [FileController::class, 'decrypt'])->name('file.decrypt');
Route::delete('/delete/{id}', [FileController::class, 'delete'])->name('file.delete');

// Route::get('/decrypt', [FileController::class, 'index'])->name('file.index');
Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::get('/', 'HomeController@index')->name('file.index');
    Route::get('/', [FileController::class, 'index'])->name('file.index');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
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

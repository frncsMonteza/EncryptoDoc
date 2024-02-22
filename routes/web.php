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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [FileController::class, 'index'])->name('file.index');
Route::post('/upload', [FileController::class, 'upload'])->name('file.upload');
Route::get('/download/{id}', [FileController::class, 'download'])->name('file.download');


Route::post('/decrypt', [FileController::class, 'decrypt'])->name('file.decrypt');
Route::delete('/delete/{id}', [FileController::class, 'delete'])->name('file.delete');

// Route::get('/decrypt', [FileController::class, 'index'])->name('file.index');
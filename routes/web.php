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

Route::controller(FileController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/upload', 'upload')->name('upload');
    Route::post('/encrypt', 'encrypt')->name('encrypt');
    Route::post('/decrypt', 'decrypt')->name('decrypt');
});

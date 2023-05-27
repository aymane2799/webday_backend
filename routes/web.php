<?php

use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

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

Route::controller(VerificationController::class)->group(function () {
    Route::get('email/verify', 'notice')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'verify')->name('verification.verify');
});

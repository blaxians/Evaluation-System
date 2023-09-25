<?php

use App\Http\Controllers\Authentication\AuthController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::any('/', 'login')->name('login')->middleware('guest');
    Route::any('/', 'logout')->name('logout')->middleware('auth');
});

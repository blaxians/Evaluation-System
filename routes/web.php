<?php

use App\Http\Controllers\Admin\Dashboard\Dashboard;
use App\Http\Controllers\Admin\Questionnaire\Questionnaire;
use App\Http\Controllers\Authentication\AuthController;
use Illuminate\Support\Facades\Route;


// Redirect the user if auth
Route::get('/redirect', function () {
    if (auth()->check()) {
        $user =  auth()->user()->role;
        if ($user === 'admin') {
            return redirect()->route('dashboard');
        } else if ($user === 'student') {
            return redirect()->route('login');
        } else {
            return redirect()->route('login');
        }
    } else {
        return redirect()->route('login');
    }
})->name('redirect');


Route::get('/loading', function () {
    if (auth()->check()) {
        return view('pages.loading');
    }
})->name('loading')->middleware('auth');


// Authentication Controller
Route::controller(AuthController::class)->group(function () {
    Route::any('/', 'login')->name('login')->middleware('guest');
    Route::any('/logout', 'logout')->name('logout')->middleware('auth');
});

// Admin Dashboard
Route::controller(Dashboard::class)->group(function () {
    // View Add
    Route::any('/dashboard', 'index')->name('dashboard')->middleware('auth');
});

// Admin Questionnaire
Route::controller(Questionnaire::class)->group(function () {
    // View Add
    Route::any('/questionnaire', 'index')->name('index.questionnaire');
})->middleware('guest');

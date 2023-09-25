<?php

use App\Http\Controllers\Admin\Questionnaire\Questionnaire;
use App\Http\Controllers\Authentication\AuthController;
use Illuminate\Support\Facades\Route;

Route::any('/dashboard', function(){
    return view('pages.admin.dashboard');
});

Route::any('/registration', function(){
    return view('pages.registration');
});



// Route::get('/redirect', function () {
//     if (auth()->check()) {
//         $user =  auth()->user()->role;
//         if ($user === 'admin') {
//             return redirect()->route('login');
//         } else if ($user === 'student') {
//             return redirect()->route('login');
//         } else {
//             return redirect()->route('login');
//         }
//     } else {
//         return redirect()->route('login');
//     }
// })->name('redirect');

// Authentication Controller
Route::controller(AuthController::class)->group(function () {
    Route::any('/', 'login')->name('login')->middleware('guest');
    Route::any('/logout', 'logout')->name('logout')->middleware('auth');
});

// Admin Questionnaire
Route::controller(Questionnaire::class)->group(function () {
    // View Add
    Route::any('/questionnaire', 'index')->name('index.questionnaire');
})->middleware('guest');

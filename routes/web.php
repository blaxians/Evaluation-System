<?php

use App\Models\YearSem;
use App\Models\Evaluation;
use App\Http\Controllers\User\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dean\Dean;
use App\Http\Controllers\Admin\Student\Student;
use App\Http\Controllers\Admin\Dashboard\Dashboard;
use App\Http\Controllers\Admin\Faculties\Faculties;
use App\Http\Controllers\Admin\Import\Import;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Admin\Questionnaire\Questionnaire;
use App\Http\Controllers\Admin\Report\Report;
use App\Models\Evaluate;

// Redirect the user if auth
Route::get('/redirect', function () {
    if (auth()->check()) {
        $user = auth()->user();
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . " " . $year_sem->semester;

        if ($user->role === 'admin') {
            return redirect()->route('index.dashboard');
        } else if ($user->role === 'student') {

            $evaluation = Evaluate::where('user_id', $user->id)->where('year_sem', $new_year_sem)->get();

            if (count($evaluation) === 0) {

                return redirect()->route('select.user');
            } else {
                return redirect()->route('index.user');
            }
        } else {
            $evaluation  = Evaluate::where('user_id', $user->id)->where('year_sem', $new_year_sem)->get();
            if (count($evaluation) === 0) {
                return redirect()->route('post2.user');
            } else {
                return redirect()->route('index.user');
            }
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
    Route::any('/change-password', 'changePassword')->name('changePassword')->middleware('auth');
});

// Admin Dashboard
Route::controller(Dashboard::class)->group(function () {
    // View Add
    Route::any('/dashboard', 'index')->name('index.dashboard')->middleware(['auth', 'admin']);
    Route::any('/dashboard/show', 'show')->name('show.dashboard')->middleware(['auth', 'admin']);
    Route::any('/dashboard/post', 'post')->name('post.dashboard')->middleware(['auth', 'admin']);
    Route::any('/dashboard/edit', 'edit')->name('edit.dashboard')->middleware(['auth', 'admin']);
    Route::any('/dashboard/stats', 'statistic')->name('statistic')->middleware(['auth', 'admin']);
});

// Admin Questionnaire
Route::controller(Questionnaire::class)->group(function () {
    // View Add
    Route::get('/questionnaire', 'index')->name('index.questionnaire')->middleware(['auth', 'admin']);
    Route::get('/questionnaire/view', 'view')->name('view.questionnaire')->middleware(['auth', 'admin']);
    Route::get('/questionnaire/show', 'show')->name('show.questionnaire')->middleware(['auth', 'admin']);
    Route::post('/questionnaire', 'post')->name('post.questionnaire')->middleware(['auth', 'admin']);
    Route::post('/questionnaire/edit', 'edit')->name('edit.questionnaire')->middleware(['auth', 'admin']);
    Route::post('/questionnaire/delete', 'delete')->name('delete.questionnaire')->middleware(['auth', 'admin']);
});

// Admin Faculties 
Route::controller(Faculties::class)->group(function () {
    // View Add
    Route::get('/faculties', 'index')->name('index.faculties')->middleware(['auth', 'admin']);
    Route::get('/faculties/view', 'view')->name('view.faculties')->middleware(['auth', 'admin']);
    Route::get('/faculties/show', 'show')->name('show.faculties')->middleware(['auth', 'admin']);
    Route::post('/faculties', 'post')->name('post.faculties')->middleware(['auth', 'admin']);
    Route::post('/faculties/edit', 'edit')->name('edit.faculties')->middleware(['auth', 'admin']);
    Route::patch('/faculties/active/{id}', 'active')->name('active.faculties')->middleware(['auth', 'admin']);
    Route::patch('/faculties/inactive/{id}', 'inActive')->name('inactive.faculties')->middleware(['auth', 'admin']);
});

// Admin Dean 
Route::controller(Dean::class)->group(function () {
    // View Add
    Route::get('/dean', 'index')->name('index.dean')->middleware(['auth', 'admin']);
    Route::get('/dean/view', 'view')->name('view.dean')->middleware(['auth', 'admin']);
    Route::get('/dean/show', 'show')->name('show.dean')->middleware(['auth', 'admin']);
    Route::post('/dean/post/', 'post')->name('post.dean')->middleware(['auth', 'admin']);
    Route::post('/dean/edit', 'edit')->name('edit.dean')->middleware(['auth', 'admin']);
});

// Admin Student
Route::controller(Student::class)->group(function () {
    // View Add
    Route::get('/students', 'index')->name('index.student')->middleware(['auth', 'admin']);
    Route::get('/student/show', 'show')->name('show.student')->middleware(['auth', 'admin']);
    Route::get('/student/view', 'view')->name('view.student')->middleware(['auth', 'admin']);
});

// Admin Report
Route::controller(Report::class)->group(function () {
    //view list of faculties
    Route::get('/report', 'index')->name('index.report')->middleware(['auth', 'admin']);
    Route::get('/report/card', 'card')->name('card')->middleware(['auth', 'admin']);
    Route::get('/report/faculties', 'show')->name('show.report')->middleware(['auth', 'admin']);
    Route::get('/report/faculties/view/student', 'viewFromStudent')->name('viewFromStudent')->middleware(['auth', 'admin']);
    Route::get('/report/faculties/view/dean', 'viewFromDean')->name('viewFromDean')->middleware(['auth', 'admin']);
    Route::post('/report/faculties/generate', 'generatePdfStudent')->name('generatePdfStudent')->middleware(['auth', 'admin']);
    Route::get('/report/faculties/generate/report', 'reportPdfStudent')->name('reportPdfStudent')->middleware(['auth', 'admin']);
});

//Admin Import
Route::controller(Import::class)->group(function () {
    Route::get('/import/student', 'index')->name('import.student')->middleware(['auth', 'admin']);
    Route::post('/import/student/post', 'import')->name('import.post')->middleware(['auth', 'admin']);
});


//User Routes
Route::controller(User::class)->group(function () {
    // View Add
    Route::get('/evaluation', 'index')->name('index.user')->middleware(['auth', 'user']);
    Route::get('/evaluation/selection', 'select')->name('select.user')->middleware(['auth', 'user']);
    Route::get('/evaluation/show', 'show')->name('show.user')->middleware(['auth', 'user']);
    Route::post('/evaluation/show/student', 'post')->name('post.user')->middleware(['auth', 'user']);
    Route::get('/evaluation/show/dean', 'post2')->name('post2.user')->middleware(['auth', 'user']);
    Route::get('/evaluation/view', 'view')->name('view.user')->middleware(['auth', 'user']);
    Route::get('/evaluation/questions', 'questions')->name('questions.user')->middleware(['auth', 'user']);
    Route::post('/evaluation/faculties', 'evaluations')->name('evaluate.user')->middleware(['auth', 'user']);
    Route::get('/evaluation/faculties/{id}', 'viewEvaluate')->name('evaluate.viewEvaluate')->middleware(['auth', 'user']);
});

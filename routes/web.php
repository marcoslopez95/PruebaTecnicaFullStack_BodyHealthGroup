<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::prefix('template')->group(function () {
    Route::get('/',function () {
        return view('template.index');
    });
});

Route::middleware([
    // 'auth:sanctum',
    // config('jetstream.auth_session'),
    // 'verified',
])->group(function () {
    //template
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('template')->group(function () {
        Route::get('/calendar', function () {
            return Inertia::render('Dashboard');
        })->name('calendar');

        Route::get('/profile', function () {
            return Inertia::render('Dashboard');
        })->name('profile');

        Route::get('/formElements', function () {
            return Inertia::render('Dashboard');
        })->name('formElements');

        Route::get('/formLayout', function () {
            return Inertia::render('Dashboard');
        })->name('formLayout');
    });

});

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
    return redirect()->route('dashboard');
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
    'auth',
    // config('jetstream.auth_session'),
    // 'verified',
])->group(function () {
    //template
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('template')->group(function () {
        Route::get('/calendar', function () {
            return Inertia::render('template/Calendar');
        })->name('calendar');

        Route::get('/profile', function () {
            return Inertia::render('template/Profile');
        })->name('profile');

        Route::get('/formElements', function () {
            return Inertia::render('template/FormElements');
        })->name('formElements');

        Route::get('/formLayout', function () {
            return Inertia::render('template/FormLayout');
        })->name('formLayout');

        Route::get('/tables', function () {
            return Inertia::render('template/TablesComponent');
        })->name('tables');

        Route::get('/settings', function () {
            return Inertia::render('template/Settings');
        })->name('settings');

        Route::get('/charts', function () {
            return Inertia::render('template/Charts');
        })->name('charts');

        Route::get('/alerts', function () {
            return Inertia::render('template/Alerts');
        })->name('alerts');

        Route::get('/buttons', function () {
            return Inertia::render('template/Buttons');
        })->name('buttons');
        // Route::get('/register', function () {
        //     return Inertia::render('Dashboard');
        // })->name('register');
    });

});

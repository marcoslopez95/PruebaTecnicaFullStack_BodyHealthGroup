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
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //template
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware('auth:sanctum')->name('dashboard');

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
    });
});

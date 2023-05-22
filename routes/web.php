<?php

use App\Http\Controllers\Web\Admin\Config\ExternalReferenceController;
use App\Http\Controllers\Web\Admin\Config\PublicationCategoryController;
use App\Http\Controllers\Web\Admin\Config\RegionController;
use App\Http\Controllers\Web\Admin\Security\PermissionController;
use App\Http\Controllers\Web\Admin\Security\RoleController;
use App\Http\Controllers\Web\Admin\Security\UserController;
use App\Http\Controllers\Web\Writer\PublicationController;
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

Route::get('/', fn () => response()->redirectTo(route('dashboard')));

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'admin/security',
    'as' => 'admin.security.'
], function () {

    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/permissions', PermissionController::class)->name('permissions');
    Route::get('/users', UserController::class)->name('users');
});

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'admin/config',
    'as' => 'admin.config.'
], function () {

    Route::get('/regions', RegionController::class)->name('regions');
    Route::get('/publication-categories', PublicationCategoryController::class)->name('publication-categories');
    Route::get('/external-references', ExternalReferenceController::class)->name('external-references');
    Route::get('/external-references', ExternalReferenceController::class)->name('external-references');
});

Route::group([
    'middleware' => ['auth:sanctum', 'role_or_permission:Admin|create publication'],
    'prefix' => 'writer',
    'as' => 'writer.'
], function () {
    Route::get('/publications', PublicationController::class)->name('publications');
});

Route::middleware([
    'auth:sanctum'
])->group(function () {
    //template
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard', [
            'user' => auth()->user(),
            'is_admin' => isAdmin(),
            'search' => request()->input('search')
        ]);
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

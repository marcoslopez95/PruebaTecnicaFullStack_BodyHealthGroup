<?php

use App\Http\Controllers\Admin\Config\ExternalReferenceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\Security\PermissionController;
use App\Http\Controllers\Admin\Security\RoleController;
use App\Http\Controllers\Admin\Security\UserController;
use App\Http\Controllers\Admin\Config\PublicationCategoryController;
use App\Http\Controllers\Admin\Config\RegionController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Writer\PublicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', RegisterController::class)->name('register');
Route::post('login', LoginController::class)->name('login');

Route::post('logout', LogoutController::class)->name('logout');

Route::group([
    'middleware' => ['role:Admin','auth:sanctum'],
    'prefix' => 'admin/security'
], function () {
    Route::apiResource('permissions', PermissionController::class);
    Route::apiResource('roles', RoleController::class);

    Route::apiResource('users', UserController::class);
    Route::put('users/{user}/restore', [UserController::class,'restore'])->name('users.restore');
});

Route::group([
    'middleware' => ['role:Admin','auth:sanctum'],
    'prefix' => 'admin/config'
], function () {
    Route::apiResource('publication-categories', PublicationCategoryController::class);
    Route::put('publication-categories/{publication_category}/restore', [PublicationCategoryController::class,'restore'])->name('publication-categories.restore');

    Route::apiResource('regions', RegionController::class);
    Route::put('regions/{region}/restore', [RegionController::class,'restore'])->name('regions.restore');

    Route::apiResource('external-references', ExternalReferenceController::class);
    Route::put('external-references/{external_reference}/restore', [ExternalReferenceController::class,'restore'])->name('external-references.restore');

    Route::apiResource('publications', PublicationController::class);
    Route::put('publications/{publication}/restore', [PublicationController::class,'restore'])->name('publications.restore');
});

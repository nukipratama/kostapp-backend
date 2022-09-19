<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group([
    'name' => 'v1.',
    'prefix' => 'v1',
], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:sanctum')->name('auth.profile');

    // Owner Kost Routes
    Route::group([
        'name' => 'owner.',
        'prefix' => 'owner/kosts',
        'middleware' => ['auth:sanctum', 'authenticatedOwner']
    ], function () {
        Route::get('/', [KostController::class, 'getKostsByOwner'])->name('kosts.getKostsByOwner');
        Route::post('/', [KostController::class, 'store'])->name('kosts.store');
        Route::put('/{kost}', [KostController::class, 'update'])->name('kosts.update');
        Route::delete('/{kost}', [KostController::class, 'destroy'])->name('kosts.destroy');
    });

    // User Kost Routes
    Route::group([
        'name' => 'kosts.',
        'prefix' => 'kosts',
        'middleware' => ['auth:sanctum', 'authenticatedUser']
    ], function () {
        Route::get('/', [KostController::class, 'index'])->name('kosts.index');
        Route::get('/availability/{kost}', [KostController::class, 'checkAvailability'])->name('kosts.checkAvailability');
        Route::get('/{kost}', [KostController::class, 'show'])->name('kosts.show');
    });
});

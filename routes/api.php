<?php

use App\Http\Controllers\APIs\AccountLocationsController;
use App\Http\Controllers\APIs\AccountRequestsController;
use App\Http\Controllers\APIs\AuthController;
use App\Http\Controllers\APIs\ContactsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->prefix('api')->middleware(['throttle:500'])->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('reset', [AuthController::class, 'reset'])->name('reset');
    Route::post('resend', [AuthController::class, 'resend'])->name('resend');
    Route::post('otp', [AuthController::class, 'otp'])->name('otp');
    Route::post('otp-check', [AuthController::class, 'otpCheck'])->name('otp.check');
    Route::post('password', [AuthController::class, 'password'])->name('password');

    Route::middleware(['auth:sanctum'])->group(function () {
        //Auth
        Route::get('profile', [\App\Http\Controllers\APIs\ProfileController::class, 'profile'])->name('profile.user');
        Route::post('profile', [\App\Http\Controllers\APIs\ProfileController::class, 'update'])->name('profile.update');
        Route::post('profile/password', [\App\Http\Controllers\APIs\ProfileController::class, 'password'])->name('profile.password');
        Route::delete('profile/destroy', [\App\Http\Controllers\APIs\ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('profile/logout', [\App\Http\Controllers\APIs\ProfileController::class, 'logout'])->name('profile.logout');
    });
});

Route::name('api.')->prefix('api/profile')->group(function () {
    Route::post('contact', [ContactsController::class, 'send'])->name('contact.send');
});

Route::middleware(['auth:sanctum'])->name('api.')->prefix('api/profile/locations')->group(function () {
    Route::get('/', [AccountLocationsController::class, 'index'])->name('locations.index');
    Route::post('/', [AccountLocationsController::class, 'store'])->name('locations.store');
    Route::get('/{location}', [AccountLocationsController::class, 'show'])->name('locations.show');
    Route::post('/{location}', [AccountLocationsController::class, 'update'])->name('locations.update');
    Route::delete('/{location}', [AccountLocationsController::class, 'destroy'])->name('locations.destroy');
});

Route::middleware(['auth:sanctum'])->name('api.')->prefix('api/profile/requests')->group(function () {
    Route::get('/', [AccountRequestsController::class, 'index'])->name('requests.index');
    Route::post('/', [AccountRequestsController::class, 'store'])->name('requests.store');
    Route::get('/{accountRequest}', [AccountRequestsController::class, 'show'])->name('requests.show');
    Route::post('/{accountRequest}', [AccountRequestsController::class, 'update'])->name('requests.update');
    Route::delete('/{accountRequest}', [AccountRequestsController::class, 'destroy'])->name('requests.destroy');
});

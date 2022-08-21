<?php

use App\Http\Controllers\AdminAuth\AdminPageController;
use App\Http\Controllers\AdminAuth\AuthenticatedSessionController;
use App\Http\Controllers\AdminAuth\NewPasswordController;
use App\Http\Controllers\AdminAuth\PasswordResetLinkController;

use Illuminate\Support\Facades\Route;

Route::name('admin.')->prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::name('admin.')->prefix('admin')->middleware('auth:admin')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
           ->name('logout');

    Route::post('upload-game', [AdminPageController::class, 'handleGameUpload'])
           ->name('upload.game');

    Route::post('delete-profile', [AdminPageController::class, 'deleteProfile'])
           ->name('delete.profile');

    Route::post('delete-game', [AdminPageController::class, 'deleteGame'])
           ->name('delete.game');


    Route::view('change-password', 'admin.auth.change-password')
           ->name('change.password');

    Route::post('change-password', [AdminPageController::class, 'changePassword']);
       
});

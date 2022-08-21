<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserProfile;

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [GameController::class, 'gameNames'])
           ->withoutMiddleware('auth')
           
           ->name('dashboard');

    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
                
    Route::get('user-profile', [UserProfile::class, 'getDataForProfile'])
           ->middleware('verified')
           ->name('user.profile');

    Route::post('change-picture', [UserProfile::class, 'changePicture'])
                 ->name('change.picture');
    
    Route::post('change-password', [UserProfile::class, 'changePassword']);
    Route::post('change-username', [UserProfile::class, 'changeUsername']);
    Route::post(('delete-profile'), [UserProfile::class, 'deleteProfile']);
    
    Route::view('change-password', 'auth.change-password')->name('change.password');
    Route::view('change-username', 'auth.change-username')->name('change.username');
    Route::view(('delete-profile'), 'auth.delete-profile')->name('delete.profile');


    Route::post('update-highscore', [GameController::class, 'updateHighscore']);
});

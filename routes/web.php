<?php

use App\Http\Controllers\AdminAuth\AdminPageController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'welcome');

Route::get('/dashboard', [GameController::class, 'gameNames'])
             ->middleware('auth')
            //  ->middleware(['auth', 'verified'])
             ->name('dashboard');

Route::get('/admin/dashboard', [AdminPageController::class, 'adminPageData'])
             ->middleware(['auth:admin'])
             ->name('admin.dashboard');

Route::get('canvas/{game}', [GameController::class, 'playGame'])->name('canvas');

require __DIR__.'/auth.php';

require __DIR__.'/admin_auth.php';

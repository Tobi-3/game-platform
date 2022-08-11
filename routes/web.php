<?php

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

Route::view('/dashboard', 'dashboard')
             ->middleware(['auth', 'verified'])
             ->name('dashboard');;

Route::view('/admin/dashboard', 'admin.dashboard')
             ->middleware(['auth:admin'])
             ->name('admin.dashboard');

require __DIR__.'/auth.php';

require __DIR__.'/admin_auth.php';
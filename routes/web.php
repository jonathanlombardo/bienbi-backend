<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppartmentController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(GuestController::class)
  ->name('guest.')
  ->group(function () {
    Route::get('/', 'index')->name('index');
  });

Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
  Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

  Route::resource('/services', ServiceController::class)->only('index');
  Route::resource('/appartments', AppartmentController::class);
});



require __DIR__ . '/auth.php';

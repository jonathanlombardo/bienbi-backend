<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;


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

  //Rotte dei messaggi
  Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
  Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
  Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');

  //rotta dei servizi
  Route::resource('/services', ServiceController::class)->only('index');


  Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
  Route::get('/plans/{id}', [PlanController::class, 'show'])->name('plans.show');
});



require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppartmentController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Models\Plan;

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
  Route::get('/messages/{appartment_slug}', [MessageController::class, 'indexMessagePerAppartment'])->name('messages.appartment.index');
  Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
  Route::get('/message/{id}', [MessageController::class, 'show'])->name('messages.show');
  Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');

  // rotta per la pagina della sponsorizzazione per un appartamento
  Route::post('/plans/payment', [PlanController::class, 'generateTransaction'])->name('plans.generateTransaction');
  Route::get('/plans/sponsor-history/{appartmentSlug?}', [PlanController::class, 'sponsorHistory'])->name('plans.history');
  Route::get('/plans/{appartmentSlug}', [PlanController::class, 'promotion'])->name('plans.promotion');

  //rotta degli appartamenti
  Route::resource('/appartments', AppartmentController::class);
});



require __DIR__ . '/auth.php';

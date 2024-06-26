<?php

use App\Http\Controllers\Api\AppartmentController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ViewsController;
use App\Models\Appartment;
use App\Models\Plan;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::get('/appartments/filtered', [AppartmentController::class, 'filtered'])->name('api.appartments.filtered');
Route::apiResource('/appartments', AppartmentController::class)->only('index', 'show');
Route::apiResource('/services', ServiceController::class)->only('index');
Route::apiResource('/messages', MessageController::class)->only('store');
Route::post('/views', [ViewsController::class, 'setView'])->name('api.views.setView');

// Route::get('/test', function () {
//   $appartment = Appartment::find(9);
//   $plan = Plan::find(1);

//   $appartment->addSponsor($plan);

//   return response()->json('test');
// });
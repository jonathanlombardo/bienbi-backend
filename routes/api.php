<?php

use App\Http\Controllers\Api\AppartmentController;
use App\Http\Controllers\ServiceController;
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

// Route::get('/test', function () {
//   $appartment = Appartment::find(9);
//   $plan = Plan::find(1);

//   $appartment->addSponsor($plan);

//   return response()->json('test');
// });
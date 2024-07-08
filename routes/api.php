<?php

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Routing\Route as RoutingRoute;
use App\Http\Controllers\ApiController\DishController;
use App\Http\Controllers\ApiController\OrderController;
use App\Http\Controllers\ApiController\TableController;
use App\Http\Controllers\ApiController\ReviewController;
use App\Http\Controllers\ApiController\ReservationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    //     
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});

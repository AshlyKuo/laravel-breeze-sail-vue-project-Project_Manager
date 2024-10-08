<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => ['auth:sanctum']], function(){
    Route::apiResource('projects', ProjectController::class);
    Route::get('/projects/{houseCode}', [ProjectController::class, 'show']);
    Route::put('/projects/{houseCode}', [ProjectController::class, 'update']);
    Route::delete('/projects/{houseCode}', [ProjectController::class, 'destroy']);

});
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => ['auth:sanctum']], function(){
    Route::apiResource('rooms', RoomController::class);
    Route::get('/rooms/{roomId}', [RoomController::class, 'show']);
    Route::put('/rooms/{roomId}', [RoomController::class, 'update']);
    Route::delete('/rooms/{roomId}', [RoomController::class, 'destroy']);

});
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => ['auth:sanctum']], function(){
    Route::apiResource('pictures', PictureController::class);
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => ['auth:sanctum']], function(){
    Route::apiResource('stock', StockController::class);
});
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => ['auth:sanctum']], function(){
    Route::apiResource('users', UserController::class);
});


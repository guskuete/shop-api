<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return response()->json([
        'hello' => 'World',
        'message' => 'The API is ready.'
    ]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

//Route::apiResource('posts', CategoryController::class)->middleware('auth:sanctum');


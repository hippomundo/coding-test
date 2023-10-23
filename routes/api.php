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
Route::middleware('auth:sanctum')->get('/tasks', [App\Http\Controllers\TaskController::class, 'index']);
Route::middleware('auth:sanctum')->post('/tasks', [App\Http\Controllers\TaskController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/users', [App\Http\Controllers\TaskController::class, 'users']);
Route::middleware('auth:sanctum')->get('/phases/{phase}', [App\Http\Controllers\PhaseController::class, 'show']);
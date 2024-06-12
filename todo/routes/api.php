<?php

use App\Http\Controllers\UserController;
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
Route::get('/first-login', [UserController::class, 'firstLogin']);
Route::prefix('tasks')->group(function () {
   Route::get('/', \App\Http\Controllers\API\Task\IndexController::class)->name('tasks.index');
   Route::post('/', \App\Http\Controllers\API\Task\StoreController::class)->name('tasks.store');
   Route::put('/{id}', \App\Http\Controllers\API\Task\UpdateController::class)->name('tasks.update');
   Route::delete('/{id}', \App\Http\Controllers\API\Task\DestroyController::class)->name('tasks.destroy');
});

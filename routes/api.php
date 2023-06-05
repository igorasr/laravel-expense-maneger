<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\UserController;

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
Route::post('/login', [LoginController::class, 'login']);
Route::post('/login/register', [UserController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/expense', [ExpensesController::class, 'index']);
    Route::post('/expense', [ExpensesController::class, 'create']);

    Route::group(['middleware' => 'expense.access'], function () {
        Route::get('/expense/{id}', [ExpensesController::class, 'getById']);
        Route::patch('/expense/{id}', [ExpensesController::class, 'save']);
        Route::delete('/expense/{id}', [ExpensesController::class, 'delete']);

    });

});






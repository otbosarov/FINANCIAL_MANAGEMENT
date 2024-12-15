<?php

use App\Http\Api\IncomeExpanseApi;
use App\Http\Api\TypeApi;
use App\Http\Api\UserApi;
use App\Http\Controllers\IncomeExpanseController;
use App\Http\Controllers\TypeController;
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



Route::post('user/register', [UserController::class, 'register']);
Route::post('user/login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    UserApi::api();
    TypeApi::api();
    IncomeExpanseApi::api();
});

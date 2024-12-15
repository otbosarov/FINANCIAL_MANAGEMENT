<?php

namespace App\Http\Api;

use App\Http\Controllers\IncomeExpanseController;
use Illuminate\Support\Facades\Route;

class IncomeExpanseApi{
    public static function api(){
        Route::get('income_expanses/get',[IncomeExpanseController::class, 'index']);
        Route::post('income_expanses/create',[IncomeExpanseController::class, 'store']);
        Route::put('income_expanses/update/{id}',[IncomeExpanseController::class, 'update']);
    }
}

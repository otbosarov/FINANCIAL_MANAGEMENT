<?php

namespace App\Http\Api;

use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

class TypeApi{
    public static function api(){
        Route::get('type/show',[TypeController::class, 'index']);
        Route::post('create/type', [TypeController::class, 'store']);
        Route::put('type/update/{id}', [TypeController::class, 'update']);
        Route::get('get_all/type',[TypeController::class, 'get_all']);
        Route::put('change_active/type/{id}', [TypeController::class, 'change_active']);

    }
}

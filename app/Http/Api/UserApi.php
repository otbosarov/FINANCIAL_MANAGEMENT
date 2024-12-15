<?php

namespace App\Http\Api;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

class UserApi {
    public static function api(){
        Route::put('user/update/{id}', [UserController::class, 'update']);
        Route::get('auth/user',[UserController::class, 'user_info']);
    }
}

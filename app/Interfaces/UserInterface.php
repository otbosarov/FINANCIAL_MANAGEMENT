<?php

namespace App\Interfaces;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserRequset;
use App\Http\Requests\UserUpdateRequest;

interface UserInterface{
    function register(UserCreateRequest $request);
    function login(UserRequset $request);
    function update(UserUpdateRequest $request, $id);
    function user_info();

}

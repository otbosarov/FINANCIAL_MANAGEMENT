<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserRequset;
use App\Http\Requests\UserUpdateRequest;
use App\Interfaces\UserInterface;
use App\Models\IncomeExpanse;
use App\Models\Type;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\select;

class UserController extends Controller
{
    public function __construct(protected UserInterface $userRepo){}
    public function register(UserCreateRequest $request)
    {
        return $this->userRepo->register($request);
    }
    public function login(UserRequset $request)
    {
        return $this->userRepo->login($request);
    }
    public function update(UserUpdateRequest $request, $id)
    {
       return $this->userRepo->update($request,$id);
    }

    public function user_info()
    {
        return $this->userRepo->user_info();
    }
}

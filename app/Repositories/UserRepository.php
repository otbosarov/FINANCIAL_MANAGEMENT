<?php

namespace App\Repositories;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserRequset;
use App\Http\Requests\UserUpdateRequest;
use App\Interfaces\UserInterface;
use App\Models\IncomeExpanse;
use App\Models\Type;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface{
    public function register(UserCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'full_name' => $request->full_name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'phone' => $request->phone
            ]);
            UserBalance::create([
                'total_value' => 0,
                'credit_value' => 0,
                'user_id' => $user->id,
            ]);

            $token = $user->createToken('auth-token')->plainTextToken;
            DB::commit();
            return response()->json(['message' => 'Siz muvaffaqiyatli ro\'yhatdan o\'tdingiz!', 'token' => $token], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Foydalanuvchi ro\'yhatdan o\'tishida xatolik berdi',
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }
    public function login(UserRequset $request)
    {
        if (strlen($request->username) == 0 || strlen($request->password) == 0)
            return 'error';

        $user = User::where('username', $request->get('username'))->first();
        if (!$user)
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);
        if (!Hash::check($request->get('password'), $user->password))
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);

        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json(['token' => $token]);
    }
    public function update(UserUpdateRequest $request, $id)
    {
        if (Auth::user()->id != $id)
            return response()->json(["message" => ['errors' => ['Boshqa foydalanuvchini ma\'lumotlarini o\'zgartirish uchun huquq yo\'q']]]);
        User::where('id', $id)
            ->update([
                'full_name' => $request->full_name,
                'password' => Hash::make($request->password),
                "phone" => $request->phone
            ]);
        return response()->json(['message' => "Ma'lumot yangilandi"], 200);
    }
    public function user_info()
    {
        $balans = UserBalance::where('user_id', Auth::user()->id)->first();

        $type = Type::get();

        $incomes = IncomeExpanse::where('income_expanses.user_id', Auth::user()->id)
            ->whereDate('income_expanses.created_at', '>=', value: date('Y-m' . '-01'))
            ->whereDate('income_expanses.created_at', '<=', date(format: 'Y-m-d'))
            ->join('types', 'types.id', 'income_expanses.type_id')
            ->select(
                "income_expanses.id",
                "income_expanses.value",
                "income_expanses.currency",
                "income_expanses.type_id",
                "income_expanses.comment",
                "income_expanses.user_id",
                "income_expanses.active",
                'income_expanses.created_at',
                'income_expanses.updated_at',
                "types.title",
                "types.is_input",
            )
            ->get();

        $incomeInput = 0;
        $incomeOutPut = 0;
        foreach ($incomes as $income) {
            if ($income->is_input) {
                $incomeInput += $income->value;
            } else {
                $incomeOutPut += $income->value;
            }
        }

        return response()->json([
            'data' => [
                'user' => Auth::user(),
                'Balans' => number_format( $balans->total_value),
                'kirim_qiymat' =>number_format( $incomeInput),
                'chiqim_qiymat' =>number_format( $incomeOutPut)
            ]
        ], 200);
    }
}

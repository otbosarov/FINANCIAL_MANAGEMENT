<?php

namespace App\Repositories;

use App\Http\Requests\IncomeExpanceRequest;
use App\Http\Requests\IncomeExpanseUpdateRequest;
use App\Http\Resources\ExpansesResource;
use App\Interfaces\IncomeExpanseInterface;
use App\Models\IncomeExpanse;
use App\Models\Type;
use App\Models\UserBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncomeExpanseRepository implements IncomeExpanseInterface
{
    public function index()
    {
        $search = request('search');
        $isInput = request('is_input'); // input output
        $dates = request('dates', []);
        $id_type = request('type_id');
        $income =  IncomeExpanse::select(
            'income_expanses.*',
            'types.title',
            'types.is_input',
            'users.full_name',
        )
            ->join('types', 'types.id', 'income_expanses.type_id')
            ->join('users', 'users.id', 'income_expanses.user_id')
            ->when(function ($query) use ($search) {
                if ($search) {
                    $query->where('types.title', 'LIKE', "%$search%")
                        ->orWhere('income_expanses.comment', 'LIKE', "%$search%");
                }
            })
            ->when($dates, function ($query) use ($dates) {
                $query->whereBetween('income_expanses.created_at', $dates);
            })
            ->when($id_type, function ($query) use ($id_type) {
                $query->where('types.id', $id_type);
            })
            ->when($isInput == 'input',function($query){
                $query->where('types.is_input',operator: true);
            })
            ->when($isInput == 'output', function($query){
                $query->where('types.is_input',false);
            })

            ->where('income_expanses.user_id', Auth::user()->id)
            ->orderByDesc('income_expanses.id')
            ->paginate(env('PG'));
        return ExpansesResource::collection($income);
    }
    public function store(IncomeExpanceRequest $request)
    {
        try {
            DB::beginTransaction();
            IncomeExpanse::create([
                'value' => $request->value,
                'currency' => $request->currency,
                'type_id' => $request->type_id,
                'comment' => $request->comment,
                'user_id' => Auth::user()->id,
            ]);
            $dataUser = UserBalance::where('user_id', Auth::user()->id)->first();
            $type = Type::where('id', $request->type_id)->first();
            if ($type->is_input) {
                $resualt =  $dataUser->total_value + $request->value;
            } else {
                $resualt = $dataUser->total_value - $request->value;
            }
            $dataUser->total_value = $resualt;
            $dataUser->save();
            DB::commit();
            return response()->json(['message' => 'Amaliyot bajarildi'], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->Xarajat_kirim_chiqimjson([
                "message " => 'Xarajat yaratish xatolik yuz berdi',
                "error" => $exception->getMessage(),
                "line" => $exception->getLine(),
                "file" => $exception->getFile()
            ], 500);
        }
    }
    public function update(IncomeExpanseUpdateRequest $request, string $id)
    {
        $dataUser = UserBalance::where("user_id", Auth::user()->id)->first();
        $incomeExpanse = IncomeExpanse::where("id", $id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if (!$incomeExpanse)
            return response()->json(['message' => ['errors' => ['Bu xarajat mavjud emas yoki sizga tegishli emas']]], 404);
        $diffarence = abs($incomeExpanse->value - $request->value);
        $type = Type::where("id", $request->type_id)->first();
        if ($type->is_input == 1) {
            if ($incomeExpanse->value < $request->value) {
                $newBalance = $dataUser->total_value + $diffarence;
            } else {
                $newBalance = $dataUser->total_value - $diffarence;
            }
        } elseif ($type->is_input == 0) {
            if ($incomeExpanse->value < $request->value) {
                $newBalance = $dataUser->total_value - $diffarence;
            } elseif ($incomeExpanse->value > $request->value) {
                $newBalance = $dataUser->total_value + $diffarence;
            }
        }
        DB::beginTransaction();
        try {
            $dataUser->total_value = $newBalance;
            $dataUser->save();
            IncomeExpanse::where("id", $id)
                ->where('user_id', Auth::user()->id)
                ->update([
                    "value" => $request->value,
                    "type_id" => $request->type_id,
                    "comment" => $request->comment
                ]);
            DB::commit();
            return response()->json(["message" => "Ma'lumot yangilandi "], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                "message" => ['errors' => ['Dasturda xatolik']]
            ], 500);
        }
    }
}

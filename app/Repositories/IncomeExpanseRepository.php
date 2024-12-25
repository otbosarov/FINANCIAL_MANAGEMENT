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

        //  if(!($this->check('category', 'show'))) return response()->json(["message" => "Amaliyotga huquq yo'q"], 403);

        $search = request('search');
        $isInput = request('isInput');  // input output
        $startDate = request('startDate');
        $endDate = request('endDate');
        $id = request('type_id');
        $income =  IncomeExpanse::select(
            'income_expanses.id',
            'income_expanses.value',
            'income_expanses.currency',
            'types.title',
            'income_expanses.comment',
            'types.is_input',
            'users.full_name',
            'income_expanses.created_at',
            'income_expanses.updated_at',
        )
            ->when(function ($query) use ($search) {
                if ($search) {
                    $query->where('types.title', 'LIKE', "%$search%")
                        ->orWhere('income_expanses.comment', 'LIKE', "%$search%");
                }
            })
            ->when($isInput, function ($query) use ($isInput) {
                $query->where('types.is_input', $isInput == 'input');
            })
            ->when($startDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('income_expanses.created_at', [
                    $startDate,
                    $endDate
                ]);
            })
            ->when($id,function($query)use($id){
                $query->where('id',$id);
            })

            ->where('income_expanses.user_id', Auth::user()->id)
            ->join('types', 'types.id', '=', 'income_expanses.type_id')
            ->join('users', 'users.id', '=', 'income_expanses.user_id')
            ->paginate(env('PG'));
        return ExpansesResource::collection($income);
    }
    public function store(IncomeExpanceRequest $request)
    {
        //  if(!($this->check('category', 'add'))) return response()->json(["message" => "Amaliyotga huquq yo'q"], 403);
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

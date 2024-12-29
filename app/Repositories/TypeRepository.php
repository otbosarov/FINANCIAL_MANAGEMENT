<?php

namespace App\Repositories;

use App\Http\Requests\TypeRequest;
use App\Http\Resources\TypeResource;
use App\Interfaces\TypeInterface;
use App\Models\Type;
use Illuminate\Http\Request;



class TypeRepository implements TypeInterface{
    public function index()
    {
        $search = request('search');
        $type = Type::with('user_type:id,full_name')->where('user_id',auth()->user()->id)
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%$search%");
            })
            ->orderByDesc('id')
            ->paginate();

        return TypeResource::collection($type);
    }
    public function store(TypeRequest $request)
    {
        Type::create([
            'title' => $request->title,
            'user_id' => auth()->id(),
            'is_input' => $request->is_input,
        ]);
        return response()->json(['message' => 'Xarajat turi yaratildi'], 201);
    }   public function update(TypeRequest $request, $id)
    {
        Type::where('id', $id)
            ->update([
                'title' => $request->title,
                'is_input' => $request->is_input,
            ]);
        return response()->json(['message' => 'Xarajat turi yangilandi'], 200);
    }
    public function get_all()
    {
        $types =  Type::where('active', '=', true)
        ->where('user_id',auth()->id())
            ->get();
        return response()->json(["data" => $types],200);
    }
    public function change_active($id)
    {
        $type = Type::find($id);
        if (!$type) {
            return  response()->json(["message" => ["errors" => ["Bu ID li xarajat turi mavjud emas"]]], 404);
        }
        $type->active = !$type->active;
        $type->save();
        return response()->json(["message" => "Amaliyot bajarildi"], 200);
    }
}

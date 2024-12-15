<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRequest;
use App\Http\Resources\TypeResource;
use App\Interfaces\TypeInterface;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{
    public function __construct(protected TypeInterface $typeRepo){}
    public function index()
    {
       return $this->typeRepo->index();
    }
    public function store(TypeRequest $request)
    {
        return $this->typeRepo->store($request);
    }
    public function update(TypeRequest $request, $id)
    {
       return $this->typeRepo->update($request,$id);
    }
    public function get_all()
    {
        return $this->typeRepo->get_all();
    }
    public function change_active($id)
    {
       return $this->typeRepo->change_active($id);
    }
}

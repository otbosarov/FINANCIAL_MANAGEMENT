<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeExpanceRequest;
use App\Http\Requests\IncomeExpanseUpdateRequest;
use App\Http\Resources\ExpansesResource;
use App\Http\Resources\IncomeExpanseResource;
use App\Interfaces\IncomeExpanseInterface;
use App\Models\IncomeExpanse;
use App\Models\Type;
use App\Models\UserBalance;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\Stub\ReturnReference;

class IncomeExpanseController extends Controller
{
    public function __construct(protected IncomeExpanseInterface $incomeExpanseRepo){}
    public function index()
    {
        return $this -> incomeExpanseRepo->index();
    }
    public function store(IncomeExpanceRequest $request)
    {
        return $this->incomeExpanseRepo->store($request);
    }

    public function update(IncomeExpanseUpdateRequest $request, string $id)
    {
      return $this->incomeExpanseRepo->update($request,$id);
    }
}

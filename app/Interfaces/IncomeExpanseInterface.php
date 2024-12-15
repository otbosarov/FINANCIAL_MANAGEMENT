<?php

namespace App\Interfaces;

use App\Http\Requests\IncomeExpanceRequest;
use App\Http\Requests\IncomeExpanseUpdateRequest;

interface IncomeExpanseInterface{
    function index();
    function store(IncomeExpanceRequest $request);
    function update(IncomeExpanseUpdateRequest $request, string $id);

}

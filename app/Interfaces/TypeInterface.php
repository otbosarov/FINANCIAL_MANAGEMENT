<?php

namespace App\Interfaces;

use App\Http\Requests\TypeRequest;

interface TypeInterface{
    function index();
    function store(TypeRequest $request);
    function update(TypeRequest $request, $id);
    function get_all();
    function change_active($id);
}

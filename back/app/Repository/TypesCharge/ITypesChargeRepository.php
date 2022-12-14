<?php

namespace App\Repository\TypesCharge;

use App\Models\TypesCharge;

interface ITypesChargeRepository
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update(TypesCharge $typesCharge,$request);
    public function destroy($model);
}


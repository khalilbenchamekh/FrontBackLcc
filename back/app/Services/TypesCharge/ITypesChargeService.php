<?php

namespace App\Services\TypesCharge;



interface ITypesChargeService{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update($id,$request);
    public function destroy($typesCharge);
}

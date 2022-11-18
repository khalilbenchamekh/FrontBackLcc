<?php

namespace App\Services\Bill;
interface IBillService
{
public function get($ref);
public function generateRef($type);
public function store($data,$ref);
public function update($bills,$data,$ref);
public function storeBillDetail($data,$billsId);

}

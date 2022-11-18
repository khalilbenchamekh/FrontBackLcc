<?php

namespace App\Repository\Bill;
interface IBillRepository
{
public function get($ref);
public function store($data,$ref);
public function storeBillDetail($data,$billsId);
public function update($bills,$data,$ref);
}

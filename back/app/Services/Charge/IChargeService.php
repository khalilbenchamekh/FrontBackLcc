<?php


namespace App\Services\Charge;

use App\Models\Charges;

interface IChargeService
{
    public function index($request);
    public function store($request);
    public function show($id);
    public function update($id,$data);
    public function destroy($request);
}

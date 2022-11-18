<?php
namespace App\Repository\Charge;
use App\Models\Charges;
interface IChargeRpository
{
    public function index($request);
    public function store($request);
    public function show($id);
    public function update(Charges $prevElem,$data);
    public function destroy($id);
}

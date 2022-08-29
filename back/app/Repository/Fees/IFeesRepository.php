<?php


namespace App\Repository\Fees;


interface IFeesRepository
{
    public function index($request);
    public function store($busines_mang,$request);
    public function show($id);
    public function update($prevElem,$data);
    public function destroy($request);
}

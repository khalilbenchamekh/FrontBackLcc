<?php


namespace App\Services\Intermediate;


interface IIntermediateService
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update($id,$request);
    public function destroy($id);
}

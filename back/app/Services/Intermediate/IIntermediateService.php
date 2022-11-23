<?php


namespace App\Services\Intermediate;


interface IIntermediateService
{
    public function save($request);
    public function index($request,$order=null);
    public function show($id);
    public function update($id,$request);
    public function destroy($id);
}

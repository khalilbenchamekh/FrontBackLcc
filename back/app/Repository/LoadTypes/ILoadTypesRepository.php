<?php
namespace App\Repository\LoadTypes;
interface ILoadTypesRepository
{
    public function index($request,$order=null);
    public function store($data);
    public function edit($data,$perLoadType);
    public function delete($id);
    public function get($id);
    public function saveManyLoadTypes($data);
}

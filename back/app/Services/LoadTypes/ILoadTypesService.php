<?php

namespace App\Services\LoadTypes;


interface ILoadTypesService
{
    public function index($request,$order=null);
    public function store($data);
    public function edit($data,$perLoadType);
    public function delete($request);
    public function get($id);
    public function saveManyLoadTypes($data);
}

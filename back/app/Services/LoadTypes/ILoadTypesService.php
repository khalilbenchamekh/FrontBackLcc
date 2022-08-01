<?php

namespace App\Services\LoadTypes;


interface ILoadTypesService
{
    public function index($idUser,$page);
    public function store($data);
    public function edit($data,$perLoadType);
    public function delete($id,$LoadType);
    public function get($id);
    public function saveManyLoadTypes($data);
}

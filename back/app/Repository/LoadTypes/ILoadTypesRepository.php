<?php

namespace App\Repository\LoadTypes;


interface ILoadTypesRepository
{
    public function index($idUser,$page);
    public function store($data);
    public function edit($data,$perLoadType);
    public function delete($id,$LoadType);
    public function get($id);
    public function saveManyLoadTypes($data);
}

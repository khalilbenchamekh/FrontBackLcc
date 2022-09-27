<?php

namespace App\Services\Mission;


interface IMissionService
{
    public function save($request);
    public function show($id);
    public function index($request);
    public function update($request,$id);
    public function destroy($id);
}

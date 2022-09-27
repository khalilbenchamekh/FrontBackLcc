<?php


namespace App\Services\FeesFolderTech;


interface IFeesFolderTechService
{
    public function save($request);
    public function index($request);
    public function update($request,$id);
    public function show($id);
    public function destroy($id);
}

<?php


namespace App\Services\Load;

interface ILoadService{
    public function index($page);
    public function store($data);
    public function edit($load,$data);
    public function show($id);
    public function destroy($id);
}

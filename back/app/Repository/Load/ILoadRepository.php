<?php
namespace App\Repository\Load;
interface ILoadRepository{
    public function index($request);
    public function store($data);
    public function edit($load,$data);
    public function show($id);
    public function destroy($id);
    public function dashboard($from,$to,$orderBy);

}

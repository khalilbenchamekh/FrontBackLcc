<?php
namespace App\Repository\FileLoad;
interface IFileLoadRepository
{
    public function  index($request);
    public function  store($data);
    public function  edit($file,$data);
    public function  delete($id);
    public function  get($id);
    public function  getLoadId($id);
}

<?php
namespace App\Service\File;
interface IFileService
{
    public function  index($request);
    public function  store($data);
    public function  edit($file,$data);
    public function  delete($id);
    public function  get($id);
}

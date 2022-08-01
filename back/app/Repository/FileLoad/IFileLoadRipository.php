<?php

namespace App\Repository\FileLoad;

interface IFileLoadRipository
{
    public function  index($page);
    public function  store($data);
    public function  edit($file,$data);
    public function  delete($id);
    public function  get($id);
    public function  getLoadId($id);
}

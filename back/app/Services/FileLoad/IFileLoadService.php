<?php

namespace App\Services\FileLoad;

interface IFileLoadService
{
public function  index($page);
public function  store($data);
public function  edit($file,$data);
public function  delete($id);
public function  get($id);
public function  getLoadId($id);

}

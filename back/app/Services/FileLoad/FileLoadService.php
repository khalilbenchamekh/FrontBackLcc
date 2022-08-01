<?php

namespace App\Services\FileLoad;

use App\Repository\FileLoad\IFileLoadRipository;

class FileLoadService implements IFileLoadService
{
    private IFileLoadRipository $fileLoadRipository;
    public function __construct(IFileLoadRipository  $fileLoadRipository)
    {
        $this->fileLoadRipository=$fileLoadRipository;
    }

    public function index($page)
    {
        // TODO: Implement index() method.
    }

    public function store($data)
    {
        // TODO: Implement store() method.
        return $this->fileLoadRipository->store($data);
    }

    public function edit($file, $data)
    {
        // TODO: Implement edit() method.
        return $this->fileLoadRipository->edit($file,$data);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        return $this->fileLoadRipository->get($id);
    }

    public function getLoadId($id)
    {
        // TODO: Implement getLoadId() method.
        return $this->fileLoadRipository->getLoadId($id);
    }
}

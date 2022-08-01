<?php

namespace App\Services\SaveFile;


interface ISaveFileService
{
    public function saveFile($direction,$files);
    public function editFile($direction,$file,$folder);
    public function deleteFile(string $path);
}

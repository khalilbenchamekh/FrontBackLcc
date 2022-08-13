<?php

namespace App\Services\ImageService;

interface IImageService
{
    public function store_image_if_is_it_base64($filesArray,$base64, $path,$prevFile);
    public function deleteFile($directory,$file);
    public function createPathIfNotExisted($filesArray);
    public function store_image($filesArray,$file,$path,$prevFile);
    public function fetchImage($directory,$image_id);
}

<?php

namespace App\Services\SaveFile;


interface ISaveFileService
{
    public function saveFile($direction,$file);
    public function saveFiles($direction,$files);
    public function editFile($direction,$file,$folder);
    public function deleteFile(string $path);
    public function saveEmployeeFiles($employee,$direction,$files);
    public function downloadFile($direction);
    public function saveFeesFiles($business,$direction,$files);
    public function saveMany($direction,$files,$key);
    public function store_file($content, $type, $fileName, $clientName);

    public function store_image_if_is_it_base64($direction,$base64,$prevFile);
    public function store_image($direction,$file,$prevFile);
    public function fetchImage($directory,$image_id);
    public function saveConversationFiles($conversation,$direction,$files);
}

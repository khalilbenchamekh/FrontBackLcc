<?php

namespace App\Services;

use App\Services\ImageService\IImageService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class ImageService implements IImageService
{

    public function store_image_if_is_it_base64($filesArray,$base64, $path,$prevFile)
    {
        try {
            $this->createPathIfNotExisted($filesArray);
            $this->deleteFile($filesArray[1],$prevFile);
            $image_parts = explode(";base64,", $base64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = md5(time()) . '.' . $image_type;
            $path = public_path() . $path;
            File::put($path . "/".$imageName, $image_base64);
            return $imageName;
        } catch (\Exception $e) {
            return null;
        }
    }
//'/geoMapping/Profile/'
    public function deleteFile($directory,$file)
    {
        if ($file != null) {
            $path = public_path($directory).'/'.$file;
            if (File::exists($path)) {
                File::delete($path);
            }
        } else {
            return null;
        }
    }

    public function createPathIfNotExisted($filesArray)
    {
        foreach ($filesArray as $item) {
            $path = public_path() . '/' . $item . '/';
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
        }
    }

    public function store_image($filesArray,$file,$path,$prevFile)
    {
        $this->createPathIfNotExisted($filesArray);
        $this->deleteFile($filesArray[1],$prevFile);
        if ($file != null) {
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = md5($filename . time()) . '.' . $extension;
            $path = public_path() . $path;
            $file->move($path, $fileNameToStore);
            return $fileNameToStore;
        } else {
            return null;
        }
    }

//$directory =='/geoMapping/Profile/'
    public function fetchImage($directory,$image_id)
    {
        if ($image_id != null) {
            $path = public_path($directory ."/". $image_id);
            if (!File::exists($path)) {
                abort(404);
            }
            $type = File::mimeType($path);
            $extension = File::extension($path);
            if ($extension != null) {
                $image_file = Image::make($path);
                $response = Response::make($image_file->encode($extension));
                $response->header('Content-Type', $type);
                return $response;
            }
        } else {
            return null;
        }
    }
}

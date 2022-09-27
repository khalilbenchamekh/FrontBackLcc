<?php

namespace App\Services\SaveFile;

use Illuminate\Support\Facades\File;

class SaveFileService implements ISaveFileService
{
    public function editFile($direction,$file,$folder)
    {

        $tale=explode('/',$direction);
        $size=count($tale);
        $ref=$size-2?$tale[$size-2]:null;
        if(isset($ref)){
            $path='geoMapping/'.$folder.'/'.$ref;
            $this->deleteFile($direction);
            $this->createFile($path);
            $filenameWithEx = $file->getClientOriginalName();
            $filename= pathinfo($filenameWithEx,PATHINFO_FILENAME);
            $extension=$file->getClientOriginalExtension();
            $fileNameToStore= $filename."_".time().".".$extension;
            $file->move(public_path()."/".$path."/",$fileNameToStore);

            return $path."/".$fileNameToStore;
        }
    }
    public function saveFile($direction,$files)
    {
        dd('rr');
        $path='geoMapping/'.$direction;
        $this->createFile($path);
            $filenameWithExt = $files->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $files->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $files->move(public_path()."/".$path."/",$fileNameToStore);
            dd( $path."/".$fileNameToStore);
           return $path."/".$fileNameToStore ;
    }
    public function createFile($path)
    {
        if (!File::isDirectory($path)){
            File::makeDirectory($path ,0777, true, true);
        }
    }
    public function deleteFile(string $path)
    {
        if(File::exists(public_path()."/".$path)) {
            File::delete(public_path()."/".$path);
        }
    }
}

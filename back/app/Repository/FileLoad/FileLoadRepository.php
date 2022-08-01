<?php

namespace App\Repository\FileLoad;

use App\Models\fileLoad;
use App\Repository\Log\LogTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class FileLoadRepository implements IFileLoadRipository
{
    use  LogTrait;

    public function index($page)
    {
        // TODO: Implement index() method.
    }

    public function store($data)
    {
        // TODO: Implement store() method.
        $organisation_id=3;
        try{
            $fileLoad=new fileLoad();
            $fileLoad->filename=$data['filename'];
            $fileLoad->organisation_id=$organisation_id;
            $fileLoad->load_id=$data['load_id'];
            $fileLoad->created_at=Carbon::now();
            $fileLoad->save();
            return  $fileLoad;
        }catch(\Exception $exception){
            dd($exception);
            $this->Log($exception);
            return null;
        }
    }

    public function edit($file, $data)
    {
        // TODO: Implement edit() method.
        $organisation_id=3;
        try {
            $file->filename=$data['filename'];
            $file->organisation_id=$organisation_id;
            $file->load_id=$data['load_id'];
            $file->updated_at=Carbon::now();
            $file->save();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        try {
            return fileLoad::destroy($id);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        $organisation_id=3;
        try {
            return DB::table("file_loads")
                ->select("*")
                ->where("organisation_id","=",$organisation_id)
                ->where("id","=",$id)
                ->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function getLoadId($id)
    {
        // TODO: Implement getLoadId() method.
        try {
            return  fileLoad::where("Load_id","=",$id)->first();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}

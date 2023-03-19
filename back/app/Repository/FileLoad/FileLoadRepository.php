<?php
namespace App\Repository\FileLoad;
use App\Models\fileLoad;
use App\Repository\Log\LogTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FileLoadRepository implements IFileLoadRepository
{
    use  LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }
    public function index($request)
    {
        try{
            return fileLoad::select()
            ->paginate($request['limit'],['*'],'page',$request['page']);
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function store($data)
    {
        // TODO: Implement store() method.

        try{
            $fileLoad=new fileLoad();
            $fileLoad->filename=$data['filename'];
            $fileLoad->organisation_id=$this->organisation_id;
            $fileLoad->load_id=$data['load_id'];
            $fileLoad->created_at=Carbon::now();
            $fileLoad->save();
            return  $fileLoad;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function edit($file, $data)
    {
        // TODO: Implement edit() method.
        try {
            $file->filename=$data['filename'];
            $file->organisation_id=$this->organisation_id;
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
        try {
            return DB::table("file_loads")
                ->select("*")
                ->where("organisation_id","=",$this->organisation_id)
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

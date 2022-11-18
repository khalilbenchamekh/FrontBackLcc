<?php
namespace App\Repository\File;
use App\Repository\File\IFileRepository;
use App\Repository\Log\LogTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\File as FileModel;

class FileRepository implements IFileRepository
{
    use  LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::User()->organisation_id;
    }
    public function index($request)
    {
        try{
            return FileModel::select()
            ->paginate($request['limit'],['*'],'page',$request['page']);
        }catch(\Exception $exception){
            dd($exception);
            $this->Log($exception);
            return null;
        }
    }

    public function store($data)
    {
        try{
            FileModel::insert($data);
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
            $file->load_id=$data['load_id'];
            $file->organisation_id=$this->organisation_id;
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
            return FileModel::destroy($id);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        try {
            return DB::table("files")
                ->select("*")
                ->where("organisation_id","=",$this->organisation_id)
                ->where("id","=",$id)
                ->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

}

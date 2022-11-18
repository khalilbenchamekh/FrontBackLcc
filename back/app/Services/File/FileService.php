<?php
namespace App\Services\File;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\File\IFileRepository;
use App\Repository\Log\LogTrait;
use App\Service\File\IFileService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\File as FileModel;
use App\Helpers\LogActivity;

class FileService implements IFileService
{
    use  LogTrait;
    private $organisation_id;
    private $iFileRepository;
    public function __construct(IFileRepository $iFileRepository)
    {
        $this->organisation_id = Auth::User()->organisation_id;
        $this->iFileRepository = $iFileRepository;
    }
    public function index($request)
    {
        return $this->iFileRepository->index($request);
    }

    public function store($request)
    {
        $typesCharge=$this->iFileRepository->store($request);
        if(!is_null($typesCharge) ){
            $subject = LogsEnumConst::Add . LogsEnumConst::FileModel. $request['filename'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return $typesCharge;
    }
    public function edit($file, $data)
    {
        $typesCharge=$this->iFileRepository->edit($file, $data);
        if(!is_null($typesCharge) ){
            $subject = LogsEnumConst::Update . LogsEnumConst::FileModel . $data['filename'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return $typesCharge;
    }

    public function delete($request)
    {
        $res = $this->iFileRepository->delete($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::FileModel . $request['filename'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }
    public function get($id)
    {
        return $this->iFileRepository->get($id);
    }
}

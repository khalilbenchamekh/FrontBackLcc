<?php
namespace App\Services\Load;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\Load\ILoadRepository;
use App\Helpers\LogActivity;

class LoadService implements ILoadService
{
    private ILoadRepository $loadRepository;
    public function __construct(ILoadRepository $loadRepository)
    {
        $this->loadRepository=$loadRepository;
    }
        public function index($page)
        {
            return $this->loadRepository->index($page);
        }
        public function dashboard($from,$to,$orderBy)
        {
            $byDateAffChoice =  $this->loadRepository->dashboard($from,$to,$orderBy);
            if(is_null($byDateAffChoice)) return null;
            $charges = [];
            $gropBy = [];
            for ($i = 0; $i < sizeof($byDateAffChoice); $i++) {
                $item = $byDateAffChoice[$i];
                array_push($charges, $item->charges);
                array_push($gropBy, $item->$orderBy);
            }
            $series = [
                [
                    "name" => "charges",
                    "data" => $charges,
                ]
            ];
            $data = [
                "series" => $series,
                "categories" => array_unique($gropBy)
            ];
            return $data;
        }
        public function store($data)
        {
            return $this->loadRepository->store($data);
        }
        public function edit($load,$data)
        {
            return $this->loadRepository->edit($load,$data);
        }
        public function destroy($request)
        {
            $res= $this->loadRepository->destroy($request['id']);
            if($res === 0 || is_null($res)){
                return false;
            }else{
                $subject = LogsEnumConst::Delete . LogsEnumConst::Intermediate . $request['REF'];
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return true;
        }

        public function show($id)
        {
            // TODO: Implement show() method.
            return $this->loadRepository->show($id);
        }
}

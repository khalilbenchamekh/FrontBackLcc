<?php

namespace App\Service\Resource;

use Carbon\Carbon;
use App\Repository\BusinessManagement\IBusinessManagementRespositry;
use App\Service\Notification\INotificationService;
use App\Services\Affaire\IAffaireService;
use App\Services\FolderTech\IFolderTechService;
use App\Services\GreatConstructionSites\IGreatConstructionSitesService;
use App\Services\User\IUserService;
use App\Events\CountDown as CountDownEvent;
use App\Http\Requests\Enums\TableChoice;
use App\Http\Resources\GetFess;
use App\Repository\Resource\IResourceRepository;
use Illuminate\Support\Facades\Cache;

class ResourceService implements IResourceService
{
    public $iBusinessManagementRespositry;
    public $iUserService;
    public $iGreatConstructionSitesService;
    public $iAffaireService;
    public $iFolderTechService;
    public $iNotificationService;
    public $iResourceRepository;
    public function __construct(
        IBusinessManagementRespositry $iBusinessManagementRespositry,
        IUserService $iUserService,
        IGreatConstructionSitesService $iGreatConstructionSitesService,
        IAffaireService $iAffaireService,
        IFolderTechService $iFolderTechService,
        INotificationService $iNotificationService,
        IResourceRepository $iResourceRepository
        )
    {
        $this->iBusinessManagementRespositry=$iBusinessManagementRespositry;
        $this->iUserService=$iUserService;
        $this->iGreatConstructionSitesService=$iGreatConstructionSitesService;
        $this->iAffaireService=$iAffaireService;
        $this->iFolderTechService=$iFolderTechService;
        $this->iNotificationService=$iNotificationService;
        $this->iResourceRepository=$iResourceRepository;
    }


    public function getLocations()
    {
        return $this->iBusinessManagementRespositry->getLocations();
    }

    public function getUser($request)
    {
        return $this->iUserService->getUser($request);
    }

    public function getCountDown()
    {
        $from = Carbon::now()->toDateString();
        $to = date("Y-m-d", strtotime(Carbon::now() . "+15 days"));

        $great =$this->iGreatConstructionSitesService->getGreatConstructionSitesBetween($from ,$to);

        $affaire = $this->iAffaireService->getAffaireBetween($from ,$to);

        $folderTech = $this->iFolderTechService->getFolderTechBetween($from ,$to);

        $arrayNotification = [];
        if (count($great) !== 0) {
            $temp = [];
            foreach ($great as $item) {
                array_push($temp, [
                    'description' => "Le Grand Chantier sous référence" . $item->Market_title . "arrivera à échéance le" . $to,
                    'created_at' => $to, 'updated_at' => $to
                ]);
            }
            array_push($arrayNotification, $temp);

        }
        if (count($affaire) !== 0) {

            $temp = [];
            foreach ($affaire as $item) {
                array_push($temp, [
                    'description' => "L'affaire sous référence" . $item->REF . "arrivera à échéance le" . $to,
                    'created_at' => $to, 'updated_at' => $to
                ]);
            }
            array_push($arrayNotification, $temp);
        }
        if (count($folderTech) !== 0) {
            $temp = [];
            foreach ($folderTech as $item) {
                array_push($temp, [
                    'description' => " Le dossier technique sous référence " . $item->REF . "arrivera à échéance le" . $to,
                    'created_at' => $to, 'updated_at' => $to
                ]);
            }
            array_push($arrayNotification, $temp);
        }
        if (!empty($arrayNotification)) {
            $notifications = $arrayNotification[0];
            if (!empty($notifications)) {
                $this->iNotificationService->insertNotification($notifications);
                broadcast(new CountDownEvent($notifications));
            }
            return $arrayNotification[0];
        }
        return null;
    }

    public function getLocationsAutoComplete($request,$order=null)
    {
        return Cache::rememberForever('location', function ($request,$order) {
            return $this->iResourceRepository->getLocationsAutoComplete($request,$order);
        });

    }

    public function getAllocatedBrigades($request,$order=null)
    {
        return $this->iResourceRepository->getAllocatedBrigades($request,$order);
    }

    public function getSearch($request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $orderBy = $request->input('orderBy');
        if (empty($from) || empty($to)) {
            $from = date("Y-m-d", strtotime(Carbon::now() . "-1 year"));
            $to = Carbon::now()->toDateString();
        }
        if (empty($orderBy)) {
            $orderBy = 'year';
        }
        $table = $request->input('table');
        if (empty($table)) {
            $table = TableChoice::Great;
        }
        $fess = new GetFess();
        $fess->set_from($from);
        $fess->set_to($to);
        $fess->set_orderBy($orderBy);
        $fess->set_table($table == TableChoice::Sites ? TableChoice::Great : $table);

        return $this->iResourceRepository->getFess($fess);
    }

    public function getSearchWithDetails($request)
    {
        $id = $request->input('id');
        $table = $request->input('table');
        if (empty($table)) {
            $table = TableChoice::Great;
        }
        $fess = new GetFess();
        $fess->set_table($table == TableChoice::Sites ? TableChoice::Great : $table);
        return $this->iResourceRepository->getDetails($fess,$id);
    }
}



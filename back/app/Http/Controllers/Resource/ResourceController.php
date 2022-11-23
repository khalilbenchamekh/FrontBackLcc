<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\PaginationRequest;
use App\Http\Requests\Search\SearchRequest;
use App\Response\AffaireNature\AllAffaireNatureResponse;
use App\Response\AffaireSituation\AffaireSituationsResponse;
use App\Response\BusinessManagements\BusinessManagementsResponse;
use App\Response\Client\ClientsResponse;
use App\Response\FolderTechNature\FolderTechNaturesResponse;
use App\Response\FolderTechSituation\FolderTechSituationsResponse;
use App\Response\Intermediate\IntermediatesResponse;
use App\Response\LoadTypes\LoadTypesResponse;
use App\Response\Notification\NotificationsReponse;
use App\Service\Notification\INotificationService;
use App\Service\Resource\IResourceService;
use App\Services\AffaireNature\AffaireNatureService;
use App\Services\AffaireSituation\IAffaireSituationService;
use App\Services\Client\IClientService;
use App\Services\FolderTechNature\IFolderTechNatureService;
use App\Services\FolderTechSituation\IFolderTechSituationService;
use App\Services\Intermediate\IIntermediateService;
use App\Services\LoadTypes\ILoadTypesService;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

class ResourceController extends Controller
{
    public $iResourceService;
    public $iIntermediateService;
    public $iClientService;
    public $iAffaireSituationService;
    public $iFolderTechSituationService;
    public $affaireNatureService;
    public $iFolderTechNatureService;
    public $iLoadTypesService;
    public $iNotificationService;
    public function __construct(
        IResourceService $iResourceService,
        IIntermediateService $iIntermediateService,
        IClientService $iClientService,
        IAffaireSituationService $iAffaireSituationService,
        IFolderTechSituationService $iFolderTechSituationService,
        AffaireNatureService $affaireNatureService,
        IFolderTechNatureService $iFolderTechNatureService,
        ILoadTypesService $iLoadTypesService,
        INotificationService $iNotificationService
    )
    {
        $this->iResourceService=$iResourceService;
        $this->iIntermediateService=$iIntermediateService;
        $this->iClientService=$iClientService;
        $this->iAffaireSituationService=$iAffaireSituationService;
        $this->iFolderTechSituationService=$iFolderTechSituationService;
        $this->affaireNatureService=$affaireNatureService;
        $this->iFolderTechNatureService=$iFolderTechNatureService;
        $this->iLoadTypesService=$iLoadTypesService;
        $this->iNotificationService=$iNotificationService;
    }

    // you need to fix reponse to this method
    public function getCountDown()
    {

        $arrayNotification= $this->iResourceService->getCountDown();
        return response($arrayNotification, 200);
    }

    public function getIntermediate(PaginationRequest $request)
    {
        $inter = $this->iIntermediateService->index($request,true);
        if($inter instanceof LengthAwarePaginator){
            $response = IntermediatesResponse::make($inter->all());
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function getClient(PaginationRequest $request)
    {
        $bus = $this->iClientService->index($request,true);
        if($bus instanceof LengthAwarePaginator){
            $response =  ClientsResponse::make($bus->items());
            return response()->json(
            [
                "data"=>$response,
                'countPage'=>$bus->perPage(),
                "currentPage"=>$bus->currentPage(),
                "nextPage"=>$bus->currentPage()<$bus->lastPage()?$bus->currentPage()+1:$bus->currentPage(),
                "lastPage"=>$bus->lastPage(),
                'total'=>$bus->total(),
            ],Response::HTTP_OK);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function getBusinessSituation(PaginationRequest $request)
    {
        $affaireSatuations = $this->iAffaireSituationService->index($request,true);
        if($affaireSatuations instanceof LengthAwarePaginator ){
            $response=AffaireSituationsResponse::make($affaireSatuations);
            return response()->json([
                'data'=>$response->items(),
                "total"=>$affaireSatuations->total(),
                "currentPage"=>$affaireSatuations->currentPage(),
                "lastPage"=>$affaireSatuations->lastPage()
            ],Response::HTTP_OK);
        }
        return \response()->json(['error'=>"Bad Request",Response::HTTP_BAD_REQUEST]);
    }


    public function geFolderTechSituation(PaginationRequest $request)
    {
        $foldertechsituations = $this->iFolderTechSituationService->index($request,true);
        if($foldertechsituations instanceof LengthAwarePaginator){
            $response = FolderTechSituationsResponse::make($foldertechsituations->all());
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function getNatureBusinessName(PaginationRequest $request)
    {
        $bus = $this->affaireNatureService->index($request,true);
        if($bus instanceof LengthAwarePaginator){
            $response = AllAffaireNatureResponse::make($bus->all());
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function getFolderTechName(PaginationRequest $request)
    {
        $bus = $this->iFolderTechNatureService->index($request,true);
        if($bus instanceof LengthAwarePaginator){
            $response= FolderTechNaturesResponse::make($bus->all());
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],Response::HTTP_OK);
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function getLocations()
    {
        $locations = $this->iResourceService->getLocations();
        $data = BusinessManagementsResponse::make($locations->items());
        return response(['data' => $data], 200);
    }

    public function getLoadType(PaginationRequest $request)
    {
        $res = $this->iLoadTypesService->index($request,true);
        if($res instanceof LengthAwarePaginator){
            $response =  LoadTypesResponse::make($res);
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],Response::HTTP_OK);
           }
           return response()->json(["error"=>"Bed Request"],Response::HTTP_BAD_REQUEST);
    }

    public function getUser()
    {
        $users = $this->iResourceService->getLocations();
        return response(['data' => $users], 200);
    }

    public function getLocationsAutoComplete(PaginationRequest $request)
    {
        $locations = $this->iResourceService->getLocationsAutoComplete($request,true);
        return response(['data' => $locations], 200);
    }

    public function getAllocatedBrigades(PaginationRequest $request)
    {
        $allocated_brigades = $this->iResourceService->getAllocatedBrigades($request,true);
        if($allocated_brigades instanceof LengthAwarePaginator){
            $response =  LoadTypesResponse::make($allocated_brigades->all());
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],Response::HTTP_OK);
           }
           return response()->json(["error"=>"Bed Request"],Response::HTTP_BAD_REQUEST);
    }

    public function getSearch(SearchRequest $request)
    {

        $fessArray = $this->iResourceService->getSearch($request);
        return response(['data' => $fessArray], 200);
    }

    public function getSearchWithDetails(Request $request)
    {
        $fessArray = $this->iResourceService->getSearchWithDetails($request);
        return response(['data' => $fessArray], 200);
    }

    public function getNotifications(PaginationRequest $request)
    {
        $notifications = $this->iNotificationService->index($request,true);
        if($notifications instanceof LengthAwarePaginator){
            $response =  NotificationsReponse::make($notifications);
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],Response::HTTP_OK);
           }
           return response()->json(["error"=>"Bed Request"],Response::HTTP_BAD_REQUEST);
    }

}

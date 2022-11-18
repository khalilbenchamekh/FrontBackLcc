<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Enums\EmailMessageChoice;
use App\Organisation;
use App\Response\Admin\AllAdminResponse;
use App\Response\Organisation\AllOrganisationResponse;
use App\Response\Organisation\OrganisationResponse;
use App\Services\Admin\IAdminService;
use App\Services\Organisation\IOrganisationService;
use App\Services\SendEmail;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganisationController
{
    private $organisationService;
    private $adminService;
    private $sendEmail;
    public function __construct(IOrganisationService $organisationService,IAdminService $adminService,SendEmail $sendEmail)
    {
        $this->organisationService=$organisationService;
        $this->adminService=$adminService;
        $this->sendEmail=$sendEmail;
    }

    public function saveImageOrganisation($id,Request $request)
    {
        $validator=Validator::make($request->all(),[
            'avatar.*' =>'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($validator->fails())
        {
            return response()->json(['data'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
        $isbase64 = $request->hasfile("avatar");
        $file = !$isbase64 ? $request->file('avatar') : $request->input('avatar');
        if($file){
            $org= $this->organisationService->saveImageOrganisation($id, $file,$isbase64);
            if($org instanceof  Organisation){
                $response = new OrganisationResponse($org);
                return response()->json(['data'=>$response,'message'=>"image saved"],Response::HTTP_ACCEPTED);
            }
        }
        return  response()->json(['error'=>'Bad Request'],Response::HTTP_BAD_REQUEST);

    }
    public function deleteImageOrganisation($id)
    {
        $org = $this->organisationService->deleteImageOrganisation($id);
        if ($org instanceof  Organisation){
            $response=new OrganisationResponse($org);
            return response()->json(['organisation'=>$response,"message"=>'organisation image deleted'],Response::HTTP_OK);
        }
                return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);

    }
    public function getImOrganisation($id)
    {
        $image= $this->organisationService->getImageOrganisation($id);
        if(isset($image)){
            return $image;
        }
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);

    }
    public function getAllOrganisation(Request $request)
    {
        $validator=Validator::make($request->all(),[
           'limit'=>'required|integer',
            'page'=>'required|integer'
        ]);
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
            $organisation = $this->organisationService->getAllOrganisation($request->all());
            if($organisation instanceof LengthAwarePaginator){
                $response= AllOrganisationResponse::make($organisation->items());
                $table=[];
                for ($i=0;$i<count($response->collection->toArray());$i++){
                    $el=$response->collection[$i];
                    $cto=$this->adminService->getUser($el->cto);
                    $el->cto=$cto->name;
                    array_push($table,$el);
                }
                return  response()->json([
                    'organisations'=>$table,
                    'countPage'=>$organisation->perPage(),
                    "currentPage"=>$organisation->currentPage(),
                    "nextPage"=>$organisation->currentPage()?$organisation->currentPage()+1:null,
                    "lastPage"=>$organisation->lastPage(),
                    'totalOrganisation'=>$organisation->total(),
                ],Response::HTTP_OK);
            }
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
    public function getOrganisation($id)
    {
        $org=$this->organisationService->getOrganisation($id);
        if ($org instanceof Organisation){
            $response = new OrganisationResponse($org);
            return response()->json(['organisation'=>$response,"message"=>'organisation'],Response::HTTP_OK);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
    public function storeOrganisation(Request $request)
    {
        $validator=Validator::make($request->all(),[
           'name'=>'required|string|max:225',
           'emailOrganisation'=>'required|email|unique:organisations',
           'description'=>'required|max:225',
            'nameCto'=>'required|string|max:225',
            'passwordCto'=>'required|integer|min:6',
            'email'=>'required|email|unique:users'
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }

            $dataCto= ["name"=>$request->input('nameCto'),"email"=>$request->input('email'),"password"=>$request->input("passwordCto")];
            $ctoCreate=$this->adminService->createUser($dataCto);
            $organisation = $this->organisationService->storeOrganisation($request,$ctoCreate);
            $addIdToCto=$this->adminService->addIdOrganisationToCto($ctoCreate,$organisation->toArray()['id']);
            if ($organisation instanceof Organisation && $addIdToCto instanceof User){
                $action=EmailMessageChoice::CREATE_ORGANISATION;
                $this->sendEmail->send($addIdToCto,$action);
                $response = new OrganisationResponse($organisation);
                $cto=$this->adminService->getUser($response->cto);;
                $response->cto=$cto->name;
                return response()->json(['organisation'=>$response,"message"=>'organisation created'],Response::HTTP_CREATED);
            }
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
    public function editOrganisation($id,Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|string|max:225',
            'emailOrganisation'=>'required|email',
            'description'=>'required|max:225',
            "cto"=>'required|integer'
        ]);
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }
            $organisation=$this->organisationService->editOrganisation($id,$request);
            $cto=$this->adminService->getUser($organisation->cto);
            if ($organisation instanceof  Organisation && $cto instanceof User){
                $action=EmailMessageChoice::EDITE_ORGANISATION;
                $this->sendEmail->send($cto,$action);
                $response=new OrganisationResponse($organisation);
                return response()->json(['organisation'=>$response,"message"=>'organisation edited'],Response::HTTP_OK);
            }else{
                if ($organisation ==false){
                    return response()->json(['error'=>"email already exist"],Response::HTTP_BAD_REQUEST);
                }
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);

    }
    public function deleteOrganisation($id)
    {
        $organisation = $this->organisationService->deleteOrganisation($id);
        $cto=$this->adminService->getUser($organisation->cto);
            if($organisation instanceof Organisation && $cto instanceof User){
                $action=EmailMessageChoice::DELETE_ORGANISATION;
                $this->sendEmail->send($cto,$action);
                $response =new OrganisationResponse($organisation);
                return  response()->json(['data'=>$response,'message'=>"Organisation Deleted"],Response::HTTP_OK);
            }
                return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
    public function enableOrganisation($id)
    {
        $organisation=$this->organisationService->enableOrganisation($id);
        $cto=$this->adminService->getUser($organisation->cto);
        if($organisation instanceof Organisation && $cto instanceof User){
            $action=EmailMessageChoice::ENABLE_ORGANISATION;
            $this->sendEmail->send($cto,$action);
            $response =new OrganisationResponse($organisation);
            return  response()->json(['data'=>$response,'message'=>"Organisation Enabled"],Response::HTTP_OK);
        }
               return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
    public function disableOrganisation($id)
    {
        $organisation=$this->organisationService->disableOrganisation($id);
        $cto=$this->adminService->getUser($organisation->cto);
        if($organisation instanceof Organisation && $cto instanceof User){
            $action=EmailMessageChoice::DISABLE_ORGANISATION;
            $this->sendEmail->send($cto,$action);
            $response =new OrganisationResponse($organisation);
            return  response()->json(['data'=>$response,'message'=>"Organisation Disabled"],Response::HTTP_OK);
        }
                 return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
    public function blockedOrganisation($id)
    {
        $organisation=$this->organisationService->blockedOrganisation($id);
        $cto=$this->adminService->getUser($organisation->cto);
        if($organisation instanceof Organisation && $cto instanceof User){
            $action=EmailMessageChoice::BLOCK_ORGANISATION;
            $this->sendEmail->send($cto,$action);
            $response =new OrganisationResponse($organisation);
            return  response()->json(['data'=>$response,'message'=>"Organisation Blocked"],Response::HTTP_OK);
        }
                  return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
    public function getAllUserOrganisation($id,Request $request){
        $validator=Validator::make($request->all(),[
            'limit'=>'required|integer',
            'page'=>'required|integer'
        ]);
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
            $userOrganisation=$this->organisationService->getAllUserOrganisation($id,$request->all());
            if($userOrganisation instanceof  LengthAwarePaginator ){
                $response= new AllAdminResponse($userOrganisation);
                return  response()->json([
                   'users'=>$response,
                    'countPage'=>$userOrganisation->perPage(),
                    "currentPage"=>$userOrganisation->currentPage(),
                    "nextPage"=>$userOrganisation->currentPage()?$userOrganisation->currentPage()+1:null,
                    "lastPage"=>$userOrganisation->lastPage(),
                   'totalOrganisation'=>$userOrganisation->total(),
               ],Response::HTTP_OK);
            }
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

}

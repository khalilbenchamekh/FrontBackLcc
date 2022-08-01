<?php

namespace App\Http\Controllers\Web;



use App\Http\Requests\Enums\EmailMessageChoice;
use App\Organisation;
use App\Request\AdminRequest;
use App\Response\Admin\AdminResponse;
use App\Response\Admin\AllAdminResponse;
use App\Services\AdminService;
use App\Services\OrganisationService;
use App\Services\SendEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;



class AdminController
{
    private $adminService;
    private $adminRequest;
    private $organisationService;
    private $sendEmail;
    public function __construct(AdminService $adminService,AdminRequest $adminRequest,OrganisationService $organisationService,SendEmail $sendEmail)
    {
        $this->adminService=$adminService;
        $this->adminRequest=$adminRequest;
        $this->organisationService=$organisationService;
        $this->sendEmail=$sendEmail;
    }
    public function getAllUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'limit'=>'required|integer',
           'page'=>'required|integer',
        ]);
        if ($validator->fails()){
            return \response()->json(['error'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }else{
            $users= $this->adminService->getAllUser($request->all());
            if($users instanceof  LengthAwarePaginator){
                $response= AllAdminResponse::make($users->items());
                return  \response()->json([
                    'users'=>$response,
                    'countPage'=>$users->perPage(),
                    "currentPage"=>$users->currentPage(),
                    "nextPage"=>$users->currentPage()<$users->lastPage()?$users->currentPage()+1:$users->currentPage(),
                    "lastPage"=>$users->lastPage(),
                    'totalOrganisation'=>$users->total(),
                ],Response::HTTP_OK);

            }else{
                return  \response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
            }
        }

    }
    public function getUserCount()
    {
       $count= $this->adminService->getUserCount();
        if (isset($count)){
            return  \response()->json(["count"=>$count],Response::HTTP_OK);
        }else{
            return  \response()->json(['HasError'=>true],Response::HTTP_NO_CONTENT);
        }
    }
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>"required|string|max:225",
            'email'=>"required|unique:users",
            "password"=>"required|max:225|min:6",
            "organisation_id"=>"required"
        ]);
        if($validator->fails()){
            return \response()->json(['error'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }else{
            $req = $this->adminRequest->req($request->all());
            $user = $this->adminService->createUser($req);
            if($user instanceof User){
                return  \response()->json(['user'=>$user],Response::HTTP_CREATED);
            }else{
                return  \response()->json([],Response::HTTP_BAD_REQUEST);
            }
        }
    }
    public function createUserToOrganisation($id,Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>"required|string|max:225",
            'email'=>"required|unique:users",
            "password"=>"required|max:225|min:6"
        ]);
        if($validator->fails()){
            return \response()->json(['error'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }else{
            $req = $this->adminRequest->req($request->all());
            $organisation=$this->organisationService->getOrganisation($id);
            $user = $this->adminService->createUserToOrganisation($req,$organisation->id);
            if($user instanceof User && $organisation instanceof Organisation){
                $action=EmailMessageChoice::CREATE_USER;
                $this->sendEmail->send($user,$action);
                $response=AdminResponse::make($user);
                return  \response()->json([$response],Response::HTTP_CREATED);
            }else{
                return  \response()->json([],Response::HTTP_BAD_REQUEST);
            }
        }
    }
    public function editUser($id,Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>"required|string|max:225",
            'email'=>"required",
        ]);
        if($validator->fails()){
            return \response()->json(['error'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }else{
            $req = $this->adminRequest->req($request->all());
            $user = $this->adminService->editUser($req,$id);
            $organisation=$this->organisationService->getOrganisation($user->organisation_id);
            if($user instanceof User  && $organisation instanceof Organisation){
                $action=EmailMessageChoice::EDIT_USER;
                $this->sendEmail->send($user,$action);
                $response=AdminResponse::make($user);
                return  \response()->json([$response],Response::HTTP_OK);
            }else{
                return  \response()->json([],Response::HTTP_BAD_REQUEST);
            }
        }
    }
    public function deleteUser($id)
    {
        try {
            $user = $this->adminService->deleteUser($id);
            $organisation=$this->organisationService->getOrganisation($user->organisation_id);
            if($user instanceof User  && $organisation instanceof Organisation){
                $action=EmailMessageChoice::DELETE_USER;
                $this->sendEmail->send($user,$action);
                $response=AdminResponse::make($user);
                return  \response()->json([$response],Response::HTTP_OK);
            }else{
                return  \response()->json([],Response::HTTP_BAD_REQUEST);
            }
        }catch (\Exception $exception){
            return  \response()->json(["message"=>$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }
    public function enableUser($id)
    {
        $user=$this->adminService->enableUser($id);
        $organisation=$this->organisationService->getOrganisation($user->organisation_id);
        if ($user instanceof User  && $organisation instanceof Organisation){
            $action=EmailMessageChoice::ENABLE_USER;
            $this->sendEmail->send($user,$action);
            $response=AdminResponse::make($user);
            return \response()->json($response,Response::HTTP_OK);
        }else{
            return \response()->json(['message'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }
    public function disableUser($id)
    {
        $user=$this->adminService->disableUser($id);
        $organisation=$this->organisationService->getOrganisation($user->organisation_id);
        if ($user instanceof User && $organisation instanceof Organisation){
            $action=EmailMessageChoice::DISABLE_USER;
            $this->sendEmail->send($user,$action);
            $response=AdminResponse::make($user);
            return \response()->json($response,Response::HTTP_OK);
        }else{
            return \response()->json(['message'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }
    public function generatePasswordUser($id,Request $request)
    {
        $validator=Validator::make($request->all(),[
            "newPassword"=>"required|password|min:6"
        ]);
        if($validator->fails()){
            return \response()->json(['error'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }else{
            $user= $this->adminService->generatePassword($id,$request->input("newPassword"));
            $organisation=$this->organisationService->getOrganisation($user->organisation_id);
            if($user instanceof User  && $organisation instanceof Organisation){
                $action=EmailMessageChoice::GENERATE_PASSWORD_TO_USER;
                $this->sendEmail->send($user,$action);
                $response=AdminResponse::make($user);
                return \response()->json($response,Response::HTTP_OK);
            }else{
                return \response()->json(['message'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
            }
        }
    }
    public function blockUser($id)
    {
        $user=$this->adminService->block($id);
        $organisation=$this->organisationService->getOrganisation($user->organisation_id);
        if($user instanceof User  && $organisation instanceof Organisation){
            $action=EmailMessageChoice::BLOCK_USER;
            $this->sendEmail->send($user,$action);
            $response=AdminResponse::make($user);
            return \response()->json($response,Response::HTTP_OK);
        }else{
            return \response()->json(['message'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }
    public function getUser($id)
    {
        $user= $this->adminService->getUser($id);
        if($user instanceof  User){
            $response=AdminResponse::make($user);
             return \response()->json($response,Response::HTTP_OK);
        }else{
            return \response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }
    public function saveImage($id,Request $request){
        $validator=Validator::make($request->all(),[
            'avatar.*' =>'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($validator->fails())
        {
            return \response()->json(['data'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
        if($request->hasfile("avatar")){
            $user=$this->adminService->saveImageUser($id,$request->file('avatar'),false);
           // $org= $this->organisationService->saveImageOrganisation($id,$request->file('avatar'),false);
            if($user instanceof  User){
                $response = new AdminResponse($user);
                return \response()->json(['data'=>$response,'message'=>"image saved"],Response::HTTP_ACCEPTED);
            }else{
                return  \response()->json(['error'=>'Bad Request'],Response::HTTP_BAD_REQUEST);
            }
        }
        if($request->input('avatar')){
            $user=$this->adminService->saveImageUser($id,$request->file('avatar'),true);
            //$org= $this->organisationService->saveImageOrganisation($id,$request->input('avatar'),true);
            if($user instanceof  User){
                $response = new AdminResponse($user);
                return \response()->json(['data'=>$response,'message'=>"image saved"],Response::HTTP_ACCEPTED);
            }else{
                return  \response()->json(['error'=>'Bad Request'],Response::HTTP_BAD_REQUEST);
            }
        }
    }
    public function getImage($id){
        $image= $this->adminService->getImageUser($id);
        if(isset($image)){
            return $image;
        }else{
            return \response()->json(['error'=>'Bad Request'],Response::HTTP_BAD_REQUEST);
        }
    }

}

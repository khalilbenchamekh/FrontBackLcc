<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enums\TableChoice;
use App\Http\Resources\UserResource;
use App\Services\Admin\IAdminResourceService;
use App\Services\Role\IRoleService;
use App\Services\User\IUserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\PaginationRequest;
use Illuminate\Support\Facades\Validator;

class AdminResourceController extends Controller
{
    private $iUserService;
    private $iRoleService;
    private $iAdminResource;
    public function __construct(IUserService $iUserService,IRoleService $iRoleService,IAdminResourceService $iAdminResource)
    {
        $this->middleware('role:owner', ['except' => ['getUsers']]);
        $this->iUserService = $iUserService;
        $this->iAdminResource = $iAdminResource;
        $this->iRoleService = $iRoleService;
    }

    public function setUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'permission' => 'required|string|min:4|max:255',
            'user' => 'required|integer',
            'attach_or_detach' => 'boolean'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $permission = $request->input('permission');
        $attach_or_detach = $request->input('attach_or_detach');
        $id = $request->input('user');
        $user = $this->iUserService->get($id);
        $role = $this->iRoleService->like($permission);
        $res = $this->iAdminResource->setUsers($role,$user,$permission);
        $data = new UserResource($user);
        return response()->json(compact('data'));
    }

    public function getUsers(Request $request)
    {
        $data = $this->iAdminResource->getUsers($request);
        return response()->json(compact('data'));
    }

    public function getRoles()
    {
         $data = $this->iAdminResource->getRoles();
        return response()->json(compact('data'));
    }

    public function getRoutes()
    {
        $data = $this->iAdminResource->getRoutes();
        return response()->json(compact('data'));
    }

    public function getPermissions()
    {
        $data = $this->iAdminResource->getPermissions();
        return response()->json(compact('data'));
    }
    public function getDefaultElementOfDashBoard(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $orderBy = $request->input('orderBy');
        $table = $request->input('table');
        if (!empty($table)) {

            $validator = Validator::make($request->all(), [
                'table' => 'in:affaires,folderteches,sites,all',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        } else {
            $table = TableChoice::All;
        }
        if (!empty($from) || !empty($to)) {

            $validator = Validator::make($request->all(), [
                'from' => 'date_format:Y/m/d',
                'to' => 'date_format:Y/m/d',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        } else {
            $from = date("Y-m-d", strtotime(Carbon::now() . "-1 year"));
            $to = Carbon::now()->toDateString();
        }

        if (!empty($orderBy)) {
            $validator = Validator::make($request->all(), [
                'orderBy' => 'in:year,month',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        } else {
            $orderBy = 'year';
        }

        $data = $this->iAdminResource->getDefaultElementOfDashBoard($table,$from,$to,$orderBy);
        return response()->json(compact('data'));
    }

    public function logActivity(PaginationRequest $request)
    {
        $data = $this->iAdminResource->logActivity($request);
        return response()->json(compact('data'));
    }
}

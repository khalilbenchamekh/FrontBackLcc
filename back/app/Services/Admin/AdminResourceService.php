<?php

namespace App\Services\Admin;
use App\Helpers\LogActivity;
use App\Services\Role\IRoleService;
use App\Repository\Admin\IAdminResourceRepository;
class AdminResourceService implements IAdminResourceService{

    private $iRoleService;
    private $iAdminResourceRepository;

    public function __construct(IRoleService $iRoleService,IAdminResourceRepository $iAdminResourceRepository){
        $this->iRoleService = $iRoleService;
        $this->iAdminResourceRepository = $iAdminResourceRepository;
    }
    public function setUsers($role,$user,$attach_or_detach){
        if (!empty($role) && !empty($user)) {
            if (isset($role->id)) {
                    $attach_or_detach == true ?
                    $user->attachRole($role->id) :
                    $user->detachRole($role->id);
            }
        }
        return $user;
    }
    public function getUsers($request){
        $permission =  $this->iRoleService->likePermission($request->input('route_name'));
        $usersArray = [];
        if (!empty($permission)) {
            $users = $this->iAdminResourceRepository->getUsers();
            for ($i = 0; $i < sizeof($users); $i++) {
                $user = $users[$i];
                    $user = $users[$i];
                    $tempUser = [
                        'user' => $user->firstname . ' ' . $user->lastname,
                        'id' => $user->id,
                        'create' => $user->can([$request->input('route_name') . '_' . 'create']),
                        'edit' => $user->can([$request->input('route_name') . '_' . 'edit']),
                        'delete' => $user->can([$request->input('route_name') . '_' . 'delete']),
                        'read' => $user->can([$request->input('route_name') . '_' . 'read']),
                    ];
                    array_push($usersArray, $tempUser);
            }
        }
        return $usersArray;
    }
    public function getRoles(){
        return $this->iAdminResourceRepository->getRoles();
    }
    public function getRoutes(){
        return $this->iAdminResourceRepository->getRoutes();
    }
    public function getPermissions(){
        return $this->iAdminResourceRepository->getPermissions();
    }
    public function getDefaultElementOfDashBoard($table,$from,$to,$orderBy){
        $res =  $this->iAdminResourceRepository->getDefaultElementOfDashBoard($table,$from,$to,$orderBy);
        $dataEn_cours = [];
        $factures_impayées = [];
        $factures_payées = [];
        $dataTeminé = [];
        $gropBy = [];
        for ($i = 0; $i < sizeof($res['fessArray']); $i++) {
            $item = $res['fessArray'][$i];
            array_push($factures_impayées, $item->factures_impayées);
            array_push($factures_payées, $item->factures_payées);
            array_push($gropBy, $item->$orderBy);
        }
        for ($i = 0; $i < sizeof($res['byDateAffChoice']); $i++) {
            $item = $res['byDateAffChoice'][$i];
            array_push($dataEn_cours, $item->projets_en_cours);
            array_push($dataTeminé, $item->projets_terminés);
            array_push($gropBy, $item->$orderBy);
        }
        for ($i = 0; $i < sizeof($res['sites']); $i++) {
            $item = $res['sites'][$i];
            array_push($dataEn_cours, $item->projets_en_cours);
            array_push($dataTeminé, $item->projets_terminés);
            array_push($gropBy, $item->$orderBy);
        }

        for ($i = 0; $i < sizeof($res['byDateFolChoice']); $i++) {
            $item = $res['byDateFolChoice'][$i];
            array_push($dataEn_cours, $item->projets_en_cours);
            array_push($dataTeminé, $item->projets_terminés);
            array_push($gropBy, $item->$orderBy);
        }
        $series = [
            [
                "name" => "projets encours",
                "data" => $dataEn_cours,
            ], [
                "name" => "projets terminés",
                "data" => $dataTeminé,
            ], [
                "name" => "factures impayées",
                "data" => $factures_impayées,
            ], [
                "name" => "factures_payées",
                "data" => $factures_payées,
            ],

        ];
        $data = [
            "series" => $series,
            "categories" => array_unique($gropBy)
        ];
        return $data;
    }
    public function logActivity($request){
        $log = new LogActivity();
        return $log->logActivityLists($request);
    }
}

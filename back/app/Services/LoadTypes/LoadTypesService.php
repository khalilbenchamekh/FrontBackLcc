<?php

namespace App\Services\LoadTypes;

use App\Services\LoadTypes\ILoadTypesService;
use App\Repository\LoadTypes\ILoadTypesRepository;




class LoadTypesService implements ILoadTypesService
{

    public $loadTypesRepository;
    public function __construct(ILoadTypesRepository $loadTypesRepository)
    {
        $this->loadTypesRepository=$loadTypesRepository;
    }

    public function index($idUser,$page)
    {

       return  $this->loadTypesRepository->index($idUser,$page);
    }
    public function store($data)
    {
       return $this->loadTypesRepository->store($data);
    }
    public function edit($data,$perLoadType)
    {
        return $this->loadTypesRepository->edit($data,$perLoadType);
    }
    public function delete($id,$LoadType)
    {
        return $this->loadTypesRepository->delete($id,$LoadType);
    }
    public function get($id)
    {
        return $this->loadTypesRepository->get($id);
    }
    public function saveManyLoadTypes($data)
    {
        return $this->loadTypesRepository->saveManyLoadTypes($data);
    }
}

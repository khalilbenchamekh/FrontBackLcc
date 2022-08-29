<?php

namespace App\Services\Client;

use App\Repository\Log\LogTrait;
use App\Repository\Client\IClientRepository;

class ClientService implements IClientService
{
    
    private $iClientRepository;
    public function __construct(IClientRepository $iClientRepository)
    {
        $this->iClientRepository=$iClientRepository;
    }

    public function index($page)
    {
        return $this->iClientRepository->index($page);
    }
    public function storeBusiness($data,$bus)
    {
        return $this->iClientRepository->storeBusiness($data,$bus);
    }
    public function storeParticular($data,$par)
    {
        return $this->iClientRepository->storeParticular($data,$par);
    }
    public function store($data)
    {
        return $this->iClientRepository->store($data);
    }
    public function get($id)
    {
        return $this->iClientRepository->get($id);
    }
    public function edit($perClient,$data)
    {
        return $this->iClientRepository->edit($perClient,$data);
    }
    public function delete($perClient, $id)
    {
        return $this->iClientRepository->delete($perClient,$id);
    }
}

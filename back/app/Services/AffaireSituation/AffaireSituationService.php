<?php

namespace App\Services\AffaireSituation;

use App\Repository\AffaireSituation\IAffaireSituationRepository;

class AffaireSituationService implements IAffaireSituationService
{
    private $affaireSituationRepository;
    public function __construct(IAffaireSituationRepository $affaireSituationRepository)
    {
        $this->affaireSituationRepository=$affaireSituationRepository;
    }

    public function index($page)
    {
        // TODO: Implement index() method.
        return $this->affaireSituationRepository->index($page);
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        return $this->affaireSituationRepository->get($id);
    }

    public function edit($perAffaireSituation, $data)
    {
        // TODO: Implement edit() method.
        return $this->affaireSituationRepository->edit($perAffaireSituation, $data);
    }

    public function delete($perAffaireSitution,$id)
    {
        // TODO: Implement delete() method.
        return $this->affaireSituationRepository->delete($perAffaireSitution,$id);
    }

    public function store($data)
    {
        // TODO: Implement store() method.
        return $this->affaireSituationRepository->store($data);
    }

    public function storeMany($data)
    {
        // TODO: Implement storeMany() method.
        return $this->affaireSituationRepository->storeMany($data);
    }
}

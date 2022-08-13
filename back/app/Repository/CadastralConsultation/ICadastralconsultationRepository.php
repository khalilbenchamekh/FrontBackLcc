<?php

namespace App\Repository\CadastralConsultation;

use App\Models\Cadastralconsultation;

interface ICadastralConsultationRepository
{
    public function index($request);
    public function get($id);
    public function edit(Cadastralconsultation $prevElem,$data);
    public function delete($id);
    public function store($data);
}

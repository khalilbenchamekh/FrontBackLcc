<?php
namespace App\Repository\CadastralConsultation;
interface ICadastralConsultationRepository
{
    public function index($request);
    public function get($id);
    public function edit($prevElem,$data);
    public function delete($id);
    public function store($data);
}

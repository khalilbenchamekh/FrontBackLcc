<?php

namespace App\Services\CadastralConsultation;


interface ICadastralconsultationService
{
    public function index($request);
    public function store($request);
    public function show($id);
    public function update($id,$request);
    public function destroy($request);
}

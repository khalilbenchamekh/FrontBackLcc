<?php

namespace App\Services\Affaire;

interface IAffaireService{
    public function save($request);
    public function show($id);
    public function index($request);
    public function update($request,$id);
    public function destroy($request);
    public function getBusiness($request);
    public function getAffaireBetween($from ,$to);
}


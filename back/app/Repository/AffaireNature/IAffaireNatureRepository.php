<?php
namespace App\Repository\AffaireNature;
use App\Models\AffaireNature;
interface IAffaireNatureRepository
{
    public function store($data);
    public function findAffaireNatureByName($id);
    public function getAllAffaireNature($request);
    public function get($id);
    public  function edit(AffaireNature $affairNature,$data);
    public  function saveMany($data);
    public function destroy($id);
}

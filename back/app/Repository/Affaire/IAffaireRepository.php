<?php
namespace App\Repository\Affaire;
use App\Models\Affaire;
interface IAffaireRepository
{
    public function save($request);
    public function show($id);
    public function index($request);
    public function update(Affaire $perElem,$request);
    public function destroy($id);
    public function getAffaireBy(array $conditions);
    public function getBusiness($request);
}

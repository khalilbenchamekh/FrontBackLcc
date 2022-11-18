<?php
namespace App\Repository\Organisation;

interface IOrganisationRepository
{
    public function checkEmail($id,$email);
    public function getAll($limit);
    public function getById($id);
    public function store($req,$cto);
    public function edit($org,$req);
    public function delete($org);
    public function enable($org);
    public function disable($org);
    public function block($org,$action);
    public function saveImage($org,$fileName);
    public function deleteImage($org);
    public function getOrganisationByCto($id);
    public function getAllUserOrganisation($organisation,$req);
}

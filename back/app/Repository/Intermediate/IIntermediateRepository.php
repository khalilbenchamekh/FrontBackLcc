<?php
namespace App\Repository\Intermediate;
use App\Models\Intermediate;
interface IIntermediateRepository
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update(Intermediate $folderTech,$request);
    public function destroy($intermediate);
}

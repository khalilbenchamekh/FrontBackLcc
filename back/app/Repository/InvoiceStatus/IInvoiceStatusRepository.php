<?php


namespace App\Repository\InvoiceStatus;

use App\Models\InvoiceStatus;

interface IInvoiceStatusRepository
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update(InvoiceStatus $folderTech,$request);
    public function destroy($intermediate);

}

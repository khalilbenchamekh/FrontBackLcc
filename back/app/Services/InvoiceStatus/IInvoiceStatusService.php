<?php


namespace App\Services\InvoiceStatus;


interface IInvoiceStatusService
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update($id,$request);
    public function destroy($id);
}

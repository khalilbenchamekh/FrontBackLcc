<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\InvoiceStatusRequest;
use App\Models\InvoiceStatus;


class InvoiceStatusController extends Controller
{
    public function __construct()
    {
        set_time_limit(8000000);
        $this->middleware('role:EtatFacture_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:EtatFacture_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:EtatFacture_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:EtatFacture_delete|owner|admin', ['only' => ['destroy']]);

    }

    public function index()
    {
        $invoicestatuses = InvoiceStatus::latest()->get();

        return response(['data' => $invoicestatuses], 200);
    }

    public function store(InvoiceStatusRequest $request)
    {
        $invoicestatus = InvoiceStatus::create($request->all());

        return response(['data' => $invoicestatus], 201);

    }

    public function show($id)
    {
        $invoicestatus = InvoiceStatus::findOrFail($id);

        return response(['data', $invoicestatus], 200);
    }

    public function update(InvoiceStatusRequest $request, $id)
    {
        $invoicestatus = InvoiceStatus::findOrFail($id);
        $invoicestatus->update($request->all());

        return response(['data' => $invoicestatus], 200);
    }

    public function destroy($id)
    {
        InvoiceStatus::destroy($id);

        return response(['data' => null], 204);
    }
}

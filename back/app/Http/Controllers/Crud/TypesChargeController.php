<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\TypesChargeRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\TypesCharge;


class TypesChargeController extends Controller
{
    public function __construct()
    {
        set_time_limit(8000000);
        $this->middleware('role:typeCharge_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:typeCharge_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:typeCharge_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:typeCharge_delete|owner|admin', ['only' => ['destroy']]);

    }

    public function index()
    {
        $typescharges = TypesCharge::latest()->get();

        return response(['data' => $typescharges], 200);
    }

    public function store(TypesChargeRequest $request)
    {
        $typescharge = TypesCharge::create($request->all());
        $subject = LogsEnumConst::Add . LogsEnumConst::LoadType . $typescharge->name;
        $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $typescharge], 201);

    }

    public function show($id)
    {
        $typescharge = TypesCharge::findOrFail($id);

        return response(['data', $typescharge], 200);
    }

    public function update(TypesChargeRequest $request, $id)
    {
        $typescharge = TypesCharge::findOrFail($id);
        $typescharge->update($request->all());
        $subject = LogsEnumConst::Add . LogsEnumConst::LoadType . $typescharge->name;
   $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $typescharge], 200);
    }

    public function destroy($id)
    {
        TypesCharge::destroy($id);

        return response(['data' => null], 204);
    }
}

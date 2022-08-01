<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\ChargesRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\Charges;
use App\Models\InvoiceStatus;
use App\Models\TypesCharge;
use Illuminate\Support\Facades\File;

class ChargesController extends Controller
{

    public function __construct()
    {
        set_time_limit(8000000);
        $this->middleware('role:charges_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:charges_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:charges_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:charges_delete|owner|admin', ['only' => ['destroy']]);

    }

    public function index()
    {
        $charges = Charges::latest()->get();

        return response(['data' => $charges], 200);
    }

    public function store(ChargesRequest $request)
    {
        $charges = new Charges();
        $charges->typeSchargeId = $request->input('typeSchargeId');
        $charges->invoiceStatusId = $request->input('invoiceStatus_id');
        $charges->others = $request->input('others');
        $charges->observation = $request->input('observation');
        $charges->desi = $request->input('desi');
        $charges->date_fac = $request->input('date_fac');
        $charges->date_pai = $request->input('date_pai');
        $charges->date_del = $request->input('date_del');
        $charges->unite = $request->input('unite');
        $charges->num_quit = $request->input('num_quit');
        $charges->archive = $request->input('archive');
        $charges->isPayed = $request->input('isPayed');
        $charges->reste = $request->input('reste');
        $charges->avence = $request->input('avence');
        $charges->somme_due = $request->input('somme_due');
        $in = InvoiceStatus::find($request->input('invoiceStatus_id'));
        $ty = TypesCharge::find($request->input('typeSchargeId'));
        $charges->invoiceStatus()->associate($in);
        $charges->typeCharges()->associate($ty);
        $charges->save();
        $subject = LogsEnumConst::Add . LogsEnumConst::Load . $charges->id;
        if ($request->hasfile('filenames')) {

            $filesArray = [
                'geoMapping',
                'geoMapping/Load',
            ];
            $pathToMove = 'geoMapping/Load/' . $charges->id;
            array_push($filesArray, $pathToMove);
            foreach ($filesArray as $item) {
                $path = public_path() . '/' . $item . '/';
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
            }

            foreach ($request->file('filenames') as $file) {
                $name = $file->getClientOriginalName();
                $path = public_path() . '/' . $pathToMove;
                $file->move($path, $name);

            }

            array_pop($filesArray);

        }
        $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $charges], 201);

    }

    public function show($id)
    {
        $charges = Charges::findOrFail($id);

        return response(['data', $charges], 200);
    }

    public function update(ChargesRequest $request, $id)
    {
        $charges = Charges::findOrFail($id);
        $charges->update($request->all());
        $subject = LogsEnumConst::Update . LogsEnumConst::Load . $charges->id;
        if ($request->hasfile('filenames')) {

            $filesArray = [
                'geoMapping',
                'geoMapping/Load',
            ];
            $pathToMove = 'geoMapping/Load/' . $charges->id;
            array_push($filesArray, $pathToMove);
            foreach ($filesArray as $item) {
                $path = public_path() . '/' . $item . '/';
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
            }

            foreach ($request->file('filenames') as $file) {
                $name = $file->getClientOriginalName();
                $path = public_path() . '/' . $pathToMove;
                $file->move($path, $name);

            }

            array_pop($filesArray);

        }
        $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $charges], 200);
    }

    public function destroy($id)
    {
        Charges::destroy($id);

        return response(['data' => null], 204);
    }
}

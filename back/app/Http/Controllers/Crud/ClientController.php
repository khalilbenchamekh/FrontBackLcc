<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\ClientRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\business;
use App\Models\Client;
use App\Models\Particular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{

    public function __construct()
    {
        set_time_limit(8000000);
        $this->middleware('role:clients_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:clients_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:clients_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:clients_delete|owner|admin', ['only' => ['destroy']]);

    }


    public function index()
    {
        $clients = Client::with('membership')->get();
        $clients_records = [];
        foreach ($clients as $client) {
            if (!empty($client)) {
                $data = [
                    "name" => $client->name,
                    "Street" => $client->Street,
                    "Street2" => $client->Street2,
                    "city" => $client->city,
                    "ZIP_code" => $client->ZIP_code,
                    "Country" => $client->Country,
                    "id" => $client->id,
                    "ICE" => $client->membership->ICE,
                    "id_mem" => $client->membership->id,
                    "RC" => $client->membership->ICE,
                    "tel" => $client->membership->ICE,
                    "Cour" => $client->membership->ICE,
                    "updated_at" => $client->membership->ICE,
                    "created_at" => $client->membership->ICE,
                ];
                $clients_records[] = $data;
            }
        }


        return response(['data' => $clients_records], 200);
    }

    public function storeBusiness(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:255|distinct|unique:App\Models\Client',
            'ICE' => 'required|string|min:4|max:255|distinct|unique:App\Models\business',
            'RC' => 'required|string|min:4|max:255|distinct|unique:App\Models\business',
            'tel' => 'required|string|min:10|max:255',
            'Cour' => 'required|string|max:255',
            'Street' => 'string|max:255',
            'Street2' => 'string|max:255',
            'city' => 'string|max:255',
            'ZIP_code' => 'string|max:255',
            'Country' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $client = new Client();
        $client->name = $request->input('name');
        $client->Street = $request->input('Street');
        $client->Street2 = $request->input('Street2');
        $client->city = $request->input('city');
        $client->ZIP_code = $request->input('ZIP_code');
        $client->Country = $request->input('Country');
//        $client->$request->input('client_id');
//        $client->$request->input('client_type');

        $bus = new business();
        $bus->ICE = $request->input('ICE');
        $bus->RC = $request->input('RC');
        $bus->tel = $request->input('tel');
        $bus->Cour = $request->input('Cour');

        $bus->save();

        $client->membership()->associate($bus);
        $client->save();
        $data = [
            "name" => $client->name,
            "Street" => $client->Street,
            "Street2" => $client->Street2,
            "city" => $client->city,
            "ZIP_code" => $client->ZIP_code,
            "Country" => $client->Country,
            "id" => $client->id,
            "ICE" => $client->membership->ICE,
            "id_mem" => $client->membership->id,
            "RC" => $client->membership->ICE,
            "tel" => $client->membership->ICE,
            "Cour" => $client->membership->ICE,
            "updated_at" => $client->membership->ICE,
            "created_at" => $client->membership->ICE,
        ];
        $subject = LogsEnumConst::Add . LogsEnumConst::Client . $data['ICE'];
   $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $data], 201);
    }

    public function storeParticular(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:255|distinct|unique:App\Models\Client',
            'Function' => 'required|string|max:255',
            'tel' => 'required|string|min:10|max:255',
            'Cour' => 'required|string|max:255',
            'Street' => 'string|max:255',
            'Street2' => 'string|max:255',
            'city' => 'string|max:255',
            'ZIP code' => 'string|max:255',
            'Country' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $client = new Client();
        $client->name = $request->input('name');
        $client->Street = $request->input('Street');
        $client->Street2 = $request->input('Street2');
        $client->city = $request->input('city');
        $client->ZIP_code = $request->input('ZIP_code');
        $client->Country = $request->input('Country');
//        $client->$request->input('client_id');
//        $client->$request->input('client_type');

        $bus = new Particular();
        $bus->Function = $request->input('Function');
        $bus->tel = $request->input('tel');
        $bus->Cour = $request->input('Cour');

        $bus->save();

        $client->membership()->associate($bus);
        $client->save();
        $subject = LogsEnumConst::Add . LogsEnumConst::Particular . $client->name;
   $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $client], 201);
    }


    public function store(ClientRequest $request)
    {
        $client = Client::create($request->all());

        return response(['data' => $client], 201);

    }

    public function show($id)
    {
        $client = Client::findOrFail($id);

        return response(['data', $client], 200);
    }

    public function update(ClientRequest $request, $id)
    {
        $client = Client::findOrFail($id);

        $client->name = $request->input('name');
        $client->Street = $request->input('Street');
        $client->Street2 = $request->input('Street2');
        $client->city = $request->input('city');
        $client->ZIP_code = $request->input('ZIP_code');
        $client->Country = $request->input('Country');

//        $client->$request->input('client_id');
//        $client->$request->input('client_type');
        $bus = business::findOrFail($request->input('id_mem'));
        $bus->ICE = $request->input('ICE');
        $bus->RC = $request->input('RC');
        $bus->tel = $request->input('tel');
        $bus->Cour = $request->input('Cour');

        $bus->update();
        $client->update();
        $data = [
            "name" => $client->name,
            "Street" => $client->Street,
            "Street2" => $client->Street2,
            "city" => $client->city,
            "ZIP_code" => $client->ZIP_code,
            "Country" => $client->Country,
            "id" => $client->id,
            "ICE" => $client->membership->ICE,
            "id_mem" => $client->membership->id,
            "RC" => $client->membership->ICE,
            "tel" => $client->membership->ICE,
            "Cour" => $client->membership->ICE,
            "updated_at" => $client->membership->ICE,
            "created_at" => $client->membership->ICE,
        ];
        $subject = LogsEnumConst::Update . LogsEnumConst::Client . $data["ICE"];
   $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $data], 200);
    }

    public function destroy($id)
    {
        Client::destroy($id);

        return response(['data' => null], 204);
    }
}

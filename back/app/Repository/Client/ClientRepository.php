<?php

namespace App\Repository\Client;

use App\Models\business;
use App\Models\Particular;
use App\Repository\Log\LogTrait;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientRepository implements IClientRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::user() ? Auth::user()->organisation_id : null;
    }

    public function index($request, $order = null)
    {
        try {
            $clients = DB::table('clients')->select("*")
                ->where('organisation_id', '=', $this->organisation_id)
                ->when($order != null, function ($query) {
                    return $query->latest();
                })
                ->paginate($request['limit'], ['*'], 'page', $request['page']);
            return $clients;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function storeBusiness($data, $bus)
    {
        try {
            $client = new Client();
            $client->organisation_id = $this->organisation_id;
            $client->name = $data['name'];
            $client->Street = $data['Street'];
            $client->Street2 = isset($data['Street2']) && $data['Street2'];
            $client->city = $data['city'];
            $client->ZIP_code = $data['ZIP_code'];
            $client->Country = $data['Country'];
            $client->membership()->associate($bus);
            $client->save();
            return $client;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function business($data)
    {
        try {
            $bus = new business();
            $bus->organisation_id = $this->organisation_id;
            $bus->ICE = $data->input('ICE');
            $bus->RC = $data->input('RC');
            $bus->tel = $data->input('tel');
            $bus->Cour = $data->input('Cour');
            $bus->save();

            return $bus;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function storeParticular($data, $par)
    {
        try {
            $client = new Client();
            $client->organisation_id = $this->organisation_id;
            $client->name = $data->input('name');
            $client->Street = $data->input('Street');
            $client->Street2 = $data->input('Street2');
            $client->city = $data->input('city');
            $client->ZIP_code = $data->input('ZIP_code');
            $client->Country = $data->input('Country');
            $client->membership()->associate($par);
            $client->save();
            return $client;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function newParticular($data)
    {
        try {
            $bus = new Particular();
            $bus->Function = $data->input('Function');
            $bus->tel = $data->input('tel');
            $bus->Cour = $data->input('Cour');
            $bus->organisation_id = $this->organisation_id;
            $bus->save();
            return $bus;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function editBusiness($data, $business)
    {
        try {
                $business->ICE = $data->input('ICE');
                $business->RC = $data->input('RC');
                $business->tel = $data->input('tel');
                $business->Cour = $data->input('Cour');
                $business->organisation_id = $this->organisation_id;
                $business->save();
                return $business;

        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function store($data)
    {
        try {
            $client = new Client();

            $client->organisation_id = $this->organisation_id;
            $client->name = $data['name'];
            $client->Street = $data['Street'];
            $client->Street2 = isset($data['Street2']) && $data['Street2'];
            $client->city = $data['city'];
            $client->ZIP_code = $data['ZIP_code'];
            $client->Country = $data['Country'];
            $client->save();

            return $client;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function get($id)
    {
        try {
            $client = Client::where("id", "=", $id)->where("organisation_id", "=", $this->organisation_id)->first();
            return $client;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function edit($perClient, $data)
    {
        try {
            $perClient->name =  $data['name'];
            $perClient->Street =  $data['Street'];
            $perClient->Street2 = isset($data['Street2']) && $data['Street2'];
            $perClient->city = $data['city'];
            $perClient->ZIP_code =  $data['ZIP_code'];
            $perClient->Country =  $data['Country'];
            $perClient->save();
            return $perClient;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function delete($model)
    {
        try {
            return $model->delete();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }

    /**
     *
     * @param mixed $data
     * @param mixed $particular
     *
     * @return mixed
     */
    public function getBusinessById($id)
    {
        try {
            return  business::where("id", "=", $id)
                ->where("organisation_id", '=', $this->organisation_id)->first();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
}

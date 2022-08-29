<?php

namespace App\Repository\Client;

use App\Repository\Log\LogTrait;
use App\Models\Client;
use Illuminate\Support\Facades\DB;





class ClientRepository implements IClientRepository
{
    use LogTrait;
    public function __construct()
    {

    }

    public function index($page)
    {
        $idUser=3;
        try{
            $clients= DB::table('clients')->select("*")
                    ->where('organisation_id','=',$idUser)
                    ->paginate(15,$columns = ['*'], $pageName = 'page', $page = $page);
            return $clients;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function storeBusiness($data,$bus)
    {
        $idUser=1;
        try{
            $client = new Client();
            $client->organisation_id=$idUser;
            $client->name = $data->input('name');
            $client->Street = $data->input('Street');
            $client->Street2 = $data->input('Street2');
            $client->city = $data->input('city');
            $client->ZIP_code = $data->input('ZIP_code');
            $client->Country = $data->input('Country');
            $client->membership()->associate($bus);
            $client->save();
            return $client;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function storeParticular($data,$par)
    {
        $idUser=1;
        try{
            $client = new Client();
            $client->organisation_id=$idUser;
            $client->name = $data->input('name');
            $client->Street = $data->input('Street');
            $client->Street2 = $data->input('Street2');
            $client->city = $data->input('city');
            $client->ZIP_code = $data->input('ZIP_code');
            $client->Country = $data->input('Country');
            $client->membership()->associate($par);
            $client->save();
            return $client;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function store($data)
    {

        $idUser=3;
        try {
            $client = new Client();
            $client->organisation_id=$idUser;
            $client->name = $data->input('name');
            $client->Street = $data->input('Street');
            $client->Street2 = $data->input('Street2');
            $client->city = $data->input('city');
            $client->ZIP_code = $data->input('ZIP_code');
            $client->Country = $data->input('Country');
            $client->save();
            return $client;
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            $this->Log($exception);
            return null;
        }

    }
    public function get($id)
    {
        $idUser=3;
        try {
            $client =Client::find($id)->where("organisation_id","=",$idUser)->get();

            return $client;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function edit($perClient,$data)
    {
        try {
            $perClient->name = $data->input('name');
            $perClient->Street = $data->input('Street');
            $perClient->Street2 = $data->input('Street2');
            $perClient->city = $data->input('city');
            $perClient->ZIP_code = $data->input('ZIP_code');
            $perClient->Country = $data->input('Country');

            $perClient->save();

            return $perClient;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }

    }
    public function delete($perClient, $id)
    {
        try{
            $perClient::destroy($id);
            return $perClient;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

}


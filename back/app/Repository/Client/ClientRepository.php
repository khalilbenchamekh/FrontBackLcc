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
        $this->organisation_id = 3;
    }

    public function index($request,$order=null)
    {
        try{
            $clients= DB::table('clients')->select("*");
                        if(!is_null($order)){
                            $clients->latest();
                        }
                    $clients->where('organisation_id','=',$this->organisation_id)
                    ->paginate($request['limit'],['*'],'page',$request['page']);
            return $clients;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function storeBusiness($data,$bus)
    {
        try{
            $client = new Client();
            $client->organisation_id=$this->organisation_id;
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
     public function business($data)
    {
        try{
            $bus = new business();
            $bus->ICE = $data->input('ICE');
            $bus->RC = $data->input('RC');
            $bus->tel = $data->input('tel');
            $bus->Cour = $data->input('Cour');
            $bus->save();
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function storeParticular($data,$par)
    {
        try{
            $client = new Client();
            $client->organisation_id=$this->organisation_id;
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
    public function newParticular($data)
    {
        try{
            $bus = new Particular();
            $bus->Function = $data->input('Function');
            $bus->tel = $data->input('tel');
            $bus->Cour = $data->input('Cour');
            $bus->organisation_id=$this->organisation_id;
            $bus->save();
            return $bus;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function editBusiness($data,$particular)
    {
        try{
            if($particular instanceof  Particular){
                $particular->Function = $data->input('Function');
                $particular->tel = $data->input('tel');
                $particular->Cour = $data->input('Cour');
                $particular->organisation_id=$this->organisation_id;
                $particular->update();
                return $particular;
            }
        }catch(\Exception $exception){
            $this->Log($exception);
        }
        return null;
    }
    public function store($data)
    {
        try {
            $client = new Client();
            $client->organisation_id=$this->organisation_id;
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
        try {
            $client =Client::find($id)->where("organisation_id","=",$this->organisation_id)->get();

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
    public function delete($id)
    {
        try{
            return Client::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->destroy();
        }catch(\Exception $exception){
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
	public function getBusinessById($id) {
        try{
            return  business::findOrFail("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id);
    }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
	}
}


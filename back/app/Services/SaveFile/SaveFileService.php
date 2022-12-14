<?php
namespace App\Services\SaveFile;
use App\Services\Organisation\IOrganisationService;
use Illuminate\Support\Facades\File;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
class SaveFileService implements ISaveFileService
{
    use LogTrait;
    public IOrganisationService $organisationService;
    public  $organisation_id;
    public $mainPath;
    // public function __construct(IOrganisationService $organisationService)
    // {
    //     $this->organisationService = $organisationService;
    //     $this->organisation_id = 3;
    //      $this->mainPath = public_path() . '/' .$this->organisationService->getMyOrganisation()->name.'/';
    // }
    public function editFile($direction,$file,$folder)
    {
        $tale=explode('/',$direction);
        $size=count($tale);
        $ref=$size-2?$tale[$size-2]:null;
        if(isset($ref)){
            $path = $folder.'/'.$ref;
            $this->deleteFile($path);
            $this->saveFile($path,$file);
        }
    }
    public function downloadFile($direction){
        $file = $this->mainPath . $direction;
        if (!File::exists($file)) {
            abort(404);
        }
        return $file;
    }
    public function saveFiles($direction,$files)
    {
        foreach ($files as $file) {
            $this->saveFile($direction,$file);
        }
    }
    public function saveMany($direction,$files,$key){
        $arrayFileNames= [];
        foreach ($files as $file) {
           $resPath = $this->saveFile($direction,$file);
           array_push($arrayFileNames,[
            $key => $resPath,
            'organisation_id' => $this->organisation_id
           ]);
        }
        return $arrayFileNames;
    }
    public function saveEmployeeFiles($employee,$direction,$files)
    {
        $arrayFileNames= $this->saveMany($direction,$files,'name');
        $employee->Documents()->createMany($arrayFileNames);
    }
     public function saveFeesFiles($business,$direction,$files)
    {
        $arrayFileNames= $this->saveMany($direction,$files,'filename');
        $business->files()->createMany($arrayFileNames);
    }
     public function saveConversationFiles($conversation,$direction,$files)

    {
        $arrayFileNames= $this->saveMany($direction,$files,'fileName');
        $conversation->files()->createMany($arrayFileNames);
        $conversation->update(
            [
                'type' => 'file'
            ]
        );
        return $conversation->setAttribute('files', $arrayFileNames);
    }

    public function saveFile($direction,$file)
    {
        $path =  $this->createFile($direction);
        return $this->save($path,$file);
    }
    private function save($path,$file){
        $filenameWithExt = $file->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $file->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload Image
        $file->move($path."/",$fileNameToStore);
       return $path."/".$fileNameToStore ;
    }
    private function pathSrringToArray($path){
        $output = array();
        $chunks = explode('/', $path);
        foreach ($chunks as $i => $chunk) {
            $output[] = implode('/', array_slice($chunks, 0, $i + 1));
        }
        return $output;
    }
    private function createFile($direction)
    {
        $path=$this->mainPath.$direction;
        $filesArray = $this->pathSrringToArray($path);
        foreach ($filesArray as $item) {
            if (!File::isDirectory($item)) {
                File::makeDirectory($item, 0777, true, true);
            }
        }
        return $path;
    }
    public function deleteFile(string $path)
    {
        if(File::exists($this->mainPath.$path)) {
            File::delete($this->mainPath.$path);
        }
    }

    public function store_file($content, $type, $fileName, $clientName)
    {
        try {
            $direction = $type != null ? $clientName . '/' . $type . '/' : '';
            $path = $this->createFile($direction);
            File::put($path . $fileName, $content);
            $path = $path . $fileName;
            return $path;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function store_image_if_is_it_base64($direction,$base64,$prevFile)
    {
        try {
            $path = $this->createFile($direction);
            $this->deleteFile($path . $prevFile .'/');
            $image_parts = explode(";base64,", $base64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = md5(time()) . '.' . $image_type;
            File::put($path . "/".$imageName, $image_base64);
            return $imageName;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function store_image($direction,$file,$prevFile)
    {
            $path = $this->createFile($direction);
            $this->deleteFile($path . $prevFile .'/');
        if ($file != null) {
            return $this->save($path,$file);
        }
         return null;
    }
    public function fetchImage($directory,$image_id)
    {
        if ($image_id != null) {
            $path = $this->downloadFile($directory ."/". $image_id);
            if(is_null($path)) return null;
            $type = File::mimeType($path);
            $extension = File::extension($path);
            if ($extension != null) {
                $image_file = Image::make($path);
                $response = Response::make($image_file->encode($extension));
                $response->header('Content-Type', $type);
                return $response;
            }
        }
        return null;
    }
}

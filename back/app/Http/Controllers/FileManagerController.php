<?php

namespace App\Http\Controllers;

use App\Services\Organisation\IOrganisationService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

/**
 * Class FileManagerController
 * @package App\Http\Controllers
 */
class FileManagerController extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;
    private $const;
    private $iOrganisationService;
    public function __construct(IOrganisationService $iOrganisationService)
    {
        $this->iOrganisationService =$iOrganisationService;
        $this->const = $this->iOrganisationService->getMyOrganisation()->name;
    }

    public function downloadFunc(Request $request)
    {
        $path = $request->input('path');
        $path = $this->makeCorrectPath($path);
        $request = request();
        $token = $request->bearerToken();
        $names = $request->input('names');

        $user = JWTAuth::user();
        if ($user) {
            if (!empty($names)) {
                $name = $names[0];
                $file = "$path/$name";
                $temp = $this->generateTempPaht($file);
                if (!File::exists($temp)) {
                    abort(404);
                }
                $mimeType = File::mimeType($temp);
                if ($mimeType != 'directory') return response()->download($temp, $name);
            }
        }
        return response(null);
    }

    private function generateTempPaht($const)
    {
        $temp = public_path() . '/' . $const;
        return $temp;
    }

    private function makeCorrectPath($path = '/')
    {
        if ($path == '/') {
            $path = $$this->const;
        }
        if ($path == $$this->const) {
            $temp = $this->generateTempPaht($$this->const);
            if (!File::isDirectory($temp)) {
                File::makeDirectory($temp, 0777, true, true);
            }
        } else {
            $path = $$this->const . $path;
        }
        return $path;
    }

    private function download($path, $name, $selectedItems, $isImage = false)
    {
        $file = $isImage ? $path : "$path/$name";
        $res = Storage::disk($this->const);
        if(!$res && isset($res) && ($res!==null)){
            $filePath = $res->getDriver()->getAdapter()->applyPathPrefix($file);
            return $filePath;
        }
        return "";
    }

    public function actions(Request $request)
    {

        $validator = Validator::make($request->all(), [
            '*.uploadFiles.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'uploadFiles.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $action = $request->input('action');
        $path = $request->input('path');
        $path = $this->makeCorrectPath($path);
        $res = Storage::disk($this->const);
        $type = "";
        if(!$res && isset($res) && ($res!==null)){
            $type = $res->mimeType($path);
        }
        switch ($action) {
            case 'read':
                $extensionsAllow = $request->input('ExtensionsAllow');
                $selectedItems = $request->input('SelectedItems');
                $responseData = [
                    'files' => $this->read($path, $extensionsAllow, $selectedItems),
                    'cwd' => [
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk($this->const)->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk($this->const)->size($path),
                        'type' => $type
                    ]
                ];
                break;
            case 'create':
                $name = $request->input('name');
                $selectedItems = $request->input('SelectedItems');
                $responseData = [
                    'files' => $this->createFolder($path, $name, $selectedItems),
                    'details' => null,
                    'error' => null
                ];
                break;
            case 'delete':
                $names = $request->input('names');
                $selectedItems = $request->input('SelectedItems');
                $this->remove($path, $names, $selectedItems);
                $extensionsAllow = $request->input('ExtensionsAllow');
                $selectedItems = $request->input('SelectedItems');
                $responseData = [
                    'files' => $this->read($path, $extensionsAllow, $selectedItems),
                    'cwd' => [
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk($this->const)->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk($this->const)->size($path),
                        'type' => $type
                    ],
                    'error' => null
                ];
                break;
            case 'save':
                $fileUpload = $request->file('uploadFiles');
                $selectedItems = $request->input('SelectedItems');
                $this->upload($path, $fileUpload, $selectedItems);
                $extensionsAllow = $request->input('ExtensionsAllow');
                $selectedItems = $request->input('SelectedItems');
                $responseData = [
                    'files' => $this->read($path, $extensionsAllow, $selectedItems),
                    'cwd' => [
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk($this->const)->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk($this->const)->size($path),
                        'type' => $type
                    ],
                    'error' => null
                ];
                break;
            case 'rename':
                $name = $request->input('name');
                $newName = $request->input('newName');
                $commonFiles = $request->input('CommonFiles');
                $selectedItems = $request->input('SelectedItems');
                $this->rename($path, $name, $newName, $commonFiles, $selectedItems);
                $extensionsAllow = $request->input('ExtensionsAllow');
                $selectedItems = $request->input('SelectedItems');
                $responseData = [
                    'files' => $this->read($path, $extensionsAllow, $selectedItems),
                    'cwd' => [
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk($this->const)->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk($this->const)->size($path),
                        'type' => $type
                    ],
                    'error' => null
                ];
                break;
            case 'copy':
                $name = $request->input('names');
                $targetPath = $request->input('targetPath');
                $this->copy($path, $name, $targetPath);
                $extensionsAllow = $request->input('ExtensionsAllow');
                $selectedItems = $request->input('SelectedItems');
                $responseData = [
                    'files' => $this->read($path, $extensionsAllow, $selectedItems),
                    'cwd' => [
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk($this->const)->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk($this->const)->size($path),
                        'type' => $type
                    ],
                    'error' => null
                ];
                break;

            case 'move':
                $name = $request->input('names');
                $targetPath = $request->input('targetPath');
                $this->move($path, $name, $targetPath);
                $extensionsAllow = $request->input('ExtensionsAllow');
                $selectedItems = $request->input('SelectedItems');
                $responseData = [
                    'files' => $this->read($path, $extensionsAllow, $selectedItems),
                    'cwd' => [
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk($this->const)->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk($this->const)->size($path),
                        'type' => $type
                    ],
                    'error' => null
                ];
                break;
            case 'getDetails':
                $names = $request->input('names');
                $selectedItems = $request->input('SelectedItems');
                $responseData = [
                    'details' => $this->getDetails($path, $names, $selectedItems)
                ];
                break;
            case 'getImage':
                $selectedItems = $request->input('SelectedItems');
                return response()->download($this->download($path, null, $selectedItems, true));
            default:
                break;
        }

        return response()->json($responseData);
    }

    /**
     * @param $path
     * @param null $extensionsAllow
     * @param array $selectedItems
     * @return array
     */
    private function read($path, $extensionsAllow = null, $selectedItems = [])
    {
        $files = Storage::disk($this->const)->files($path);
        $directories = Storage::disk($this->const)->directories($path);
        $items = array_merge($files, $directories);
        $allFiles = [];
        foreach ($items as $item) {
            $type = "";
            $res =Storage::disk($this->const);
            if(!$res && isset($res) && ($res!==null)){
                $type = $res->mimeType($path);
            }
            $mimeType = $type;
            array_push($allFiles, [
                'name' => basename($item),
                'hasChild' => $mimeType == 'directory',
                'isFile' => $mimeType != 'directory',
                'type' => $mimeType,
                'dateModified' => date('Y/m/d h:i:s', Storage::disk($this->const)->lastModified($item)),
                'size' => Storage::disk($this->const)->size($item)
            ]);
        }

        return $allFiles;
    }

    /**
     * @param $path
     * @param string $name
     * @param array $selectedItems
     * @return array
     */
    private function createFolder($path, $name = 'New Folder', $selectedItems = [])
    {
        $file = "$path/$name";
        Storage::disk($this->const)->makeDirectory($file);

        $allFiles = [];
        $type = "";
        $res =Storage::disk($this->const);
        if(!$res && isset($res) && ($res!==null)){
            $type = $res->mimeType($path);
        }
        $mimeType = $type;
        $fileObject = [
            'name' => basename($file),
            'hasChild' => $mimeType == 'directory',
            'isFile' => $mimeType != 'directory',
            'type' => $mimeType,
            'dateModified' => date('Y/m/d h:i:s', Storage::disk($this->const)->lastModified($file)),
            'size' => Storage::disk($this->const)->size($file)
        ];
        array_push($allFiles, $fileObject);

        return $allFiles;
    }

    /**
     * @param $path
     * @param array $names
     * @param array $selectedItems
     */
    private function remove($path, $names = [], $selectedItems = [])
    {
        foreach ($names as $name) {
            $file = "$path/$name";
            $type = "";
            $res =Storage::disk($this->const);
            if(!$res && isset($res) && ($res!==null)){
                $type = $res->mimeType($path);
            }
            $type == 'directory' ? Storage::disk($this->const)->deleteDirectory($file) : Storage::disk($this->const)->delete($file);
        }
    }

    /**
     * @param $path
     * @param $fileUpload
     * @param array $selectedItems
     */
    private function upload($path, $fileUpload, $selectedItems = [])
    {
        $res =Storage::disk($this->const);
        if(!$res && isset($res) && ($res!==null)){
             return $res->putFileAs($path, $fileUpload, $fileUpload->getClientOriginalName());
        }
        return null;
    }

    /**
     * @param $path
     * @param $name
     * @param $newName
     * @param array $commonFiles
     * @param array $selectedItems
     */
    private function rename($path, $name, $newName, $commonFiles = [], $selectedItems = [])
    {
        $fileOld = "$path/$name";
        $fileNew = "$path/$newName";
        Storage::disk($this->const)->move($fileOld, $fileNew);
    }

    private function copy($path, $names = [], $targetPath)
    {
        foreach ($names as $name) {
            $targetPath = $this->makeCorrectPath($targetPath);
            $fileOld = "$path/$name";
            $fileNew = "$targetPath/$name";
            Storage::disk($this->const)->copy($fileOld, $fileNew);
        }
    }

    private function move($path, $names = [], $targetPath)
    {
        foreach ($names as $name) {
            $targetPath = $this->makeCorrectPath($targetPath);
            $fileOld = "$path/$name";
            $fileNew = "$targetPath/$name";
            Storage::disk($this->const)->move($fileOld, $fileNew);
        }
    }

    /**
     * @param $path
     * @param array $names
     * @param array $selectedItems
     * @return array
     */
    private function getDetails($path, $names = [], $selectedItems = [])
    {
        $files = [];
        foreach ($names as $name) {
            $file = "$path/$name";
            $res = Storage::disk($this->const);
            $type = "";
            if(!$res && isset($res) && ($res!==null)){
                $type = $res->mimeType($file);
            }
            $fileDetails = [
                'CreationTime' => 'Unknown',
                'Extension' => File::extension($file),
                'FullName' => $file,
                'Format' => $type,
                'LastWriteTime' => date('Y/m/d h:i:s', Storage::disk($this->const)->lastModified($file)),
                'LastAccessTime' => 'Unknown',
                'Length' => Storage::disk($this->const)->size($file),
                'Name' => File::name($file)
            ];
            array_push($files, $fileDetails);
        }
        return $files;
    }


}

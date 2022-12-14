<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class FileManagerController
 * @package App\Http\Controllers
 */
class FileManagerController extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;


    public function downloadFunc(Request $request)
    {
        $path = $request->input('path');
        $path = $this->makeCorrectPath($path);
        $request = request();
        $token = $request->bearerToken();
        $names = $request->input('names');
        $selectedItems = $request->input('selectedItems');
        $const = Config::get('constants.fileSystemPath');
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
                if ($mimeType != 'directory') {

                    
//                    $response = Response::make($file, 200);
//                    $response->header('Content-Type' , $mimeType);
//                    $response->header('Authorization', 'Bearer ' . $token);
//                    $response->header('Content-Disposition', 'attachment ');
//                    $response->header('filename', '{$name} ');
//                    return $response;
                    return response()->download($temp, $name);

                } else {
                    return response(null);
                }
            } else {
                return response(null);
            }

        }
    }

    private function generateTempPaht($const)
    {
        $temp = public_path() . '/' . $const;
        return $temp;
    }

    private function makeCorrectPath($path = '/')
    {
        $const = Config::get('constants.fileSystemPath');
        if ($path == '/') {
            $path = $const;
        }
        if ($path == $const) {
            $temp = $this->generateTempPaht($const);
            if (!File::isDirectory($temp)) {
                File::makeDirectory($temp, 0777, true, true);
            }
        } else {
            $path = $const . $path;
        }
        return $path;
    }

    private function download($path, $name, $selectedItems, $isImage = false)
    {
        $file = $isImage ? $path : "$path/$name";
        $filePath = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($file);
        return $filePath;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
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
        $responseData = null;
        $path = $request->input('path');
        $path = $this->makeCorrectPath($path);
        switch ($action) {
            case 'read':
                $extensionsAllow = $request->input('ExtensionsAllow');
                $selectedItems = $request->input('SelectedItems');
                $responseData = [
                    'files' => $this->read($path, $extensionsAllow, $selectedItems),
                    'cwd' => [
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk('public')->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk('public')->size($path),
                        'type' => Storage::disk('public')->mimeType($path)
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
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk('public')->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk('public')->size($path),
                        'type' => Storage::disk('public')->mimeType($path)
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
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk('public')->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk('public')->size($path),
                        'type' => Storage::disk('public')->mimeType($path)
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
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk('public')->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk('public')->size($path),
                        'type' => Storage::disk('public')->mimeType($path)
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
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk('public')->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk('public')->size($path),
                        'type' => Storage::disk('public')->mimeType($path)
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
                        'dateModified' => date('Y/m/d h:i:s', Storage::disk('public')->lastModified($path)),
                        'isFile' => false,
                        'name' => basename($path),
                        'hasChild' => false,
                        'size' => Storage::disk('public')->size($path),
                        'type' => Storage::disk('public')->mimeType($path)
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
                break;
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
        $files = Storage::disk('public')->files($path);
        $directories = Storage::disk('public')->directories($path);
        $items = array_merge($files, $directories);
        $allFiles = [];
        foreach ($items as $item) {
            $mimeType = Storage::disk('public')->mimeType($item);
            array_push($allFiles, [
                'name' => basename($item),
                'hasChild' => $mimeType == 'directory',
                'isFile' => $mimeType != 'directory',
                'type' => $mimeType,
                'dateModified' => date('Y/m/d h:i:s', Storage::disk('public')->lastModified($item)),
                'size' => Storage::disk('public')->size($item)
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
        Storage::disk('public')->makeDirectory($file);

        $allFiles = [];

        $mimeType = Storage::disk('public')->mimeType($file);
        $fileObject = [
            'name' => basename($file),
            'hasChild' => $mimeType == 'directory',
            'isFile' => $mimeType != 'directory',
            'type' => $mimeType,
            'dateModified' => date('Y/m/d h:i:s', Storage::disk('public')->lastModified($file)),
            'size' => Storage::disk('public')->size($file)
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
            $type = Storage::disk('public')->mimeType($file);
            $type == 'directory' ? Storage::disk('public')->deleteDirectory($file) : Storage::disk('public')->delete($file);
        }
    }

    /**
     * @param $path
     * @param $fileUpload
     * @param array $selectedItems
     */
    private function upload($path, $fileUpload, $selectedItems = [])

    {

//        foreach ($fileUpload as $file) {
//            $filenameWithExt = $file->getClientOriginalName();
//            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
//            $extension = $file->getClientOriginalExtension();
//            $fileNameToStore = md5($filename . time()) . '.' . $extension;
//            array_push($files, [
//                "fileName" => $fileNameToStore
//            ]);
//
//
//            $path = storage_path() . '/' . $path;
//            $file->move($path, $fileNameToStore);
//        }

        Storage::disk('public')->putFileAs($path, $fileUpload, $fileUpload->getClientOriginalName());
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
        Storage::disk('public')->move($fileOld, $fileNew);
    }

    private function copy($path, $names = [], $targetPath)
    {
        foreach ($names as $name) {
            $targetPath = $this->makeCorrectPath($targetPath);
            $fileOld = "$path/$name";
            $fileNew = "$targetPath/$name";
            Storage::disk('public')->copy($fileOld, $fileNew);
        }
    }

    private function move($path, $names = [], $targetPath)
    {
        foreach ($names as $name) {
            $targetPath = $this->makeCorrectPath($targetPath);
            $fileOld = "$path/$name";
            $fileNew = "$targetPath/$name";
            Storage::disk('public')->move($fileOld, $fileNew);
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
            $fileDetails = [
                'CreationTime' => 'Unknown',
                'Extension' => File::extension($file),
                'FullName' => $file,
                'Format' => Storage::disk('public')->mimeType($file),
                'LastWriteTime' => date('Y/m/d h:i:s', Storage::disk('public')->lastModified($file)),
                'LastAccessTime' => 'Unknown',
                'Length' => Storage::disk('public')->size($file),
                'Name' => File::name($file)
            ];
            array_push($files, $fileDetails);
        }
        return $files;
    }


}

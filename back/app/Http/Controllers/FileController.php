<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\File as FileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function index()
    {
        $files = FileModel::latest()->get();

        return response(['data' => $files], 200);
    }

    public function FileManager(Request $request)
    {
//        $directories =  Storage::disk('public')->allDirectories('geoMapping');
//        $files =  Storage::disk('public')->allFiles('geoMapping');
        $validator = Validator::make($request->all(), [
            'filename' => 'required|string|max:255',
            'type' => 'required|in:Profile,Messagerie',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $path = "geoMapping/";
        $type = $request->input("type");
        $fileName = $request->input("filename");
        if ($type == "Profile") {
            $validator = Validator::make($request->all(), [
                'user_name' => 'exists:users,username',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }

            $path = $path . $type . '/' . $request->input("user_name") . "/" . $request->input("filename");

        } else {
            $path = $path . $type . "/" . $request->input("filename");
        }
        $path = public_path('/' . $path);
        if (!File::exists($path)) {
            abort(404);
        }
        return response()->download($path, $fileName);

    }

    public function store(Request $request)
    {

        request()->validate([
            '*.filename.*' => 'required|image|mimes:jpeg,png,jpg,gif,svgdoc,pdf,docx,zip',
        ]);
        if ($request->hasfile('filename')) {

            foreach ($request->file('filename') as $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path() . '/files/', $name);
                $fileModel = new FileModel();
                $fileModel->filename = "$name";
                $fileModel->save();

            }

        }


        return response(['data' => 'Data Your files has been successfully added'], 201);


    }

    public function show($id)
    {
        $file = FileModel::findOrFail($id);

        return response(['data', $file], 200);
    }

    public function update(FileRequest $request, $id)
    {
        $file = FileModel::findOrFail($id);
        $file->update($request->all());

        return response(['data' => $file], 200);
    }

    public function destroy($id)
    {
        FileModel::destroy($id);

        return response(['data' => null], 204);
    }
}

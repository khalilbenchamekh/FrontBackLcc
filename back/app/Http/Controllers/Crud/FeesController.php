<?php
namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\FeesRequest;
use App\Http\Resources\MemberShipType;
use App\Models\Affaire;
use App\Models\File as FeesFile;
use App\Models\BusinessManagement;
use App\Models\Fees;
use App\Models\FolderTech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class FeesController extends Controller
{
    public function __construct()
    {
        set_time_limit(8000000);
        $this->middleware('role:owner|admin');
        $this->middleware('role:fees_create|owner|admin', ['only' => ['saveBusinessFees', 'saveFolderTechFees']]);
        $this->middleware('role:fees_edit|owner|admin', ['only' => ['updateBusinessFees', 'updateFolderTechFees']]);
    }

    public function getFolderTech()
    {
        $folderTech = FolderTech::latest()
            ->select('REF', 'id')
            ->get();
        return response(['data' => $folderTech], 200);
    }

    public function getBusiness()
    {
        $business = Affaire::latest()
            ->select('REF', 'id')
            ->get();
        return response(['data' => $business], 200);
    }

    public function getFolderTechFees()
    {
        $fees = Fees::where('type', 'like', '%' . "FolderTech")->get();
        return response(['data' => $fees], 200);
    }

    public function getBusinessFees()
    {
        $fees = Fees::where('type', 'like', '%' . "Affaire")->get();
        return response(['data' => $fees], 200);
    }

    public function saveBusinessFees(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'string|max:255',
            'id' => 'required|exists:affaires,id',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $id = $request->input('id');
        $busines_mang = BusinessManagement::where("membership_id", '=', $id)->where('membership_type', 'like', '%' . "Affaire")->get();
        $size = count($busines_mang);
        if ($size > 0) {
            $busines_mang_id = $busines_mang[0]->id;
            $price = $request->input('price');
            $observation = $request->input('observation');
            $advanced = $request->input('advanced');
            $fees = new Fees();
            $fees->businessManagement()->associate(
                $busines_mang_id
            );
            $fees->price = $price;
            $fees->observation = $observation;
            $fees->type = MemberShipType::business;
            $fees->advanced = $advanced;
            $fees->save();
            $business = Affaire::findOrFail($id);
            if ($request->hasfile('filenames')) {
                $filesArray = [
                    'geoMapping',
                    'geoMapping/Fees',
                ];
                $pathToMove = 'geoMapping/Fees/' . $business->REF;
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
                    $fileModel = new FeesFile();
                    $fileModel->businessManagement()->associate(
                        $busines_mang_id
                    );
                    $fileModel->filename = $path . '/' . $name;
                    $fileModel->save();
                }
                array_pop($filesArray);
            }
            return response(['data' => $fees], 200);

        } else {
            return response(['data' => $busines_mang], 200);
        }
    }

    public function saveFolderTechFees(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'string|max:255',
            'id' => 'required|exists:folderteches,id',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $id = $request->input('id');
        $busines_mang = BusinessManagement::where("membership_id", '=', $id)
        ->where('membership_type', 'like', '%' . "FolderTech")->get();
        $size = count($busines_mang);
        if ($size > 0) {
            $busines_mang_id = $busines_mang[0]->id;
            $price = $request->input('price');
            $observation = $request->input('observation');
            $advanced = $request->input('advanced');
            $fees = new Fees();
            $fees->businessManagement()->associate(
                $busines_mang_id
            );
            $fees->price = $price;
            $fees->observation = $observation;
            $fees->type = MemberShipType::folderTech;
            $fees->advanced = $advanced;
            $fees->save();
            $business = Affaire::findOrFail($id);
            if ($request->hasfile('filenames')) {
                $filesArray = [
                    'geoMapping',
                    'geoMapping/Fees',
                ];
                $pathToMove = 'geoMapping/Fees/' . $business->REF;
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
                    $fileModel = new FeesFile();
                    $fileModel->businessManagement()->associate(
                        $busines_mang_id
                    );
                    $fileModel->filename = $path . '/' . $name;
                    $fileModel->save();
                }
                array_pop($filesArray);
            }
            return response(['data' => $fees], 200);

        } else {
            return response(['data' => $busines_mang], 200);
        }
    }

    public function updateBusinessFees(Request $request, $index)
    {

        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'string|max:255',
            'id' => 'exists:affaires,id',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $id = $request->input('id');
        $busines_mang = BusinessManagement::where("membership_id", '=', $id)->where("membership_type", 'like', MemberShipType::business)->get();
        $size = count($busines_mang);
        if ($size > 0) {
            $busines_mang_id = $busines_mang->id;
            $price = $request->input('price');
            $observation = $request->input('observation');
            $advanced = $request->input('id');
            $fees = Fees::findOrFail($index);
            $fees->update([
                'price' => $price,
                'observation' => $observation,
                'type' => MemberShipType::business,
                'business_id' => $busines_mang_id,
                'advanced' => $advanced,
            ]);
            $business = Affaire::findOrFail($id);
            if ($request->hasfile('filenames')) {
                $filesArray = [
                    'geoMapping',
                    'geoMapping/Fees',
                ];
                $pathToMove = 'geoMapping/Fees/' . $business->REF;
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
                    $fileModel = new FeesFile();
                    $fileModel->businessManagement()->associate(
                        $busines_mang_id
                    );
                    $fileModel->filename = $path . '/' . $name;
                    $fileModel->save();
                }
                array_pop($filesArray);
            }
            return response(['data' => $fees], 200);

        } else {
            return response(['data' => $busines_mang], 200);
        }
    }

    public function updateFolderTechFees(Request $request, $index)
    {
        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'string|max:255',
            'id' => 'exists:affaires,id',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $id = $request->input('id');
        $busines_mang = BusinessManagement::where("membership_id", '=', $id)->where("membership_type", 'like', MemberShipType::folderTech)->get();
        $size = count($busines_mang);
        if ($size > 0) {
            $busines_mang_id = $busines_mang->id;
            $price = $request->input('price');
            $observation = $request->input('observation');
            $advanced = $request->input('id');
            $fees = Fees::findOrFail($index);
            $fees->update([
                'price' => $price,
                'observation' => $observation,
                'type' => MemberShipType::folderTech,
                'business_id' => $busines_mang_id,
                'advanced' => $advanced,
            ]);
            $business = FolderTech::findOrFail($id);
            if ($request->hasfile('filenames')) {
                $filesArray = [
                    'geoMapping',
                    'geoMapping/Fees',
                ];
                $pathToMove = 'geoMapping/Fees/' . $business->REF;
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
                    $fileModel = new FeesFile();
                    $fileModel->businessManagement()->associate(
                        $busines_mang_id
                    );
                    $fileModel->filename = $path . '/' . $name;
                    $fileModel->save();
                }
                array_pop($filesArray);
            }
            return response(['data' => $fees], 200);

        } else {
            return response(['data' => $busines_mang], 200);
        }
    }

}

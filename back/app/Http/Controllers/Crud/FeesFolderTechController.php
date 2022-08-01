<?php
namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\FeesFolderTechRequest;
use App\Models\FeesFolderTech;

class FeesFolderTechController extends Controller
{



    public function index()
    {
        $feesfolderteches = FeesFolderTech::latest()->get();

        return response(['data' => $feesfolderteches ], 200);
    }

    public function store(FeesFolderTechRequest $request)
    {
        $feesfoldertech = FeesFolderTech::create($request->all());

        return response(['data' => $feesfoldertech ], 201);

    }

    public function show($id)
    {
        $feesfoldertech = FeesFolderTech::findOrFail($id);

        return response(['data', $feesfoldertech ], 200);
    }

    public function update(FeesFolderTechRequest $request, $id)
    {
        $feesfoldertech = FeesFolderTech::findOrFail($id);
        $feesfoldertech->update($request->all());

        return response(['data' => $feesfoldertech ], 200);
    }

    public function destroy($id)
    {
        FeesFolderTech::destroy($id);

        return response(['data' => null ], 204);
    }
}

<?php

namespace App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\IntermediateRequest;
use App\Models\Intermediate;

class IntermediateController extends Controller
{
    public function __construct()
    {
        set_time_limit(8000000);
        $this->middleware('role:intermediates_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:intermediates_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:intermediates_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:intermediates_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index()
    {
        $intermediates = Intermediate::latest()->get();

        return response(['data' => $intermediates ], 200);
    }

    public function store(IntermediateRequest $request)
    {
        $intermediate = Intermediate::create($request->all());


        
        return response(['data' => $intermediate ], 201);

    }

    public function show($id)
    {
        $intermediate = Intermediate::findOrFail($id);

        return response(['data', $intermediate ], 200);
    }

    public function update(IntermediateRequest $request, $id)
    {
        $intermediate = Intermediate::findOrFail($id);
        $intermediate->update($request->all());

        return response(['data' => $intermediate ], 200);
    }

    public function destroy($id)
    {
        Intermediate::destroy($id);

        return response(['data' => null ], 204);
    }
}

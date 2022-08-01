<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MissionRequest;
use App\Models\Mission;
use DateTime;
use Illuminate\Support\Facades\Validator;


class MissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:owner');
    }
    public function index()
    {
        $missions = Mission::latest()->get();
        return response(['data' => $missions ], 200);
    }

    public function store(MissionRequest $request)
    {
        $title = $request->input('text');
        $Description = $request->input('description');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $allDay = $request->input('allDay');
        if(!empty($allDay)){

            $validator = Validator::make($request->all(), [
                'allDay' => 'required|in:0,1',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(),400);
            }
        }else{
            $allDay=0;
        }



        $mission = new Mission();
        $mission->text =$title;
        $mission->description =$Description;
        $mission->startDate =  date("Y-m-d H:i:s",strtotime(date($startDate)));
        $mission->endDate =  date("Y-m-d H:i:s",strtotime(date($endDate)));
        $mission->allDay =$allDay;
        $mission->save();
        return response(['data' => $mission ], 201);

    }

    public function show($id)
    {
        $mission = Mission::findOrFail($id);

        return response(['data', $mission ], 200);
    }

    public function update(MissionRequest $request, $id)
    {
        $title = $request->input('text');
        $Description = $request->input('description');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $allDay = $request->input('allDay');
        if(!empty($allDay)){

            $validator = Validator::make($request->all(), [
                'allDay' => 'required|in:0,1',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(),400);
            }
        }else{
            $allDay=0;
        }
        $mission = Mission::findOrFail($id);

        $mission->text =$title;
        $mission->description =$Description;
        $mission->startDate =  date("Y-m-d H:i:s",strtotime(date($startDate)));
        $mission->endDate =  date("Y-m-d H:i:s",strtotime(date($endDate)));
        $mission->allDay =$allDay;
        $mission->update();
        return response(['data' => $mission ], 200);
    }

    public function destroy($id)
    {
        Mission::destroy($id);

        return response(['data' => null ], 204);
    }
}

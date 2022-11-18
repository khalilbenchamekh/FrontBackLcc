<?php

use App\Imports\Locations;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CsvTableSeeder extends Seeder
{
    
    public function run()
    {
        $locations =Location::where('name','like','Tanger'.'%')->get();
        if (empty($locations)) {
            $file=public_path().'/csvs/locations.xlsx';
            Excel::import(new Locations, $file);
        }
    }
}

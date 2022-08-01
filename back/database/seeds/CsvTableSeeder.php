<?php

use App\Imports\Locations;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CsvTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $file=public_path().'/csvs/locations.xlsx';
        Excel::import(new Locations, $file);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 07/04/2020
 * Time: 15:56
 */

namespace App\Imports;
use App\Models\Location;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class Locations implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Location::create([
                'name' => $row[0],
            ]);
        }
    }
}

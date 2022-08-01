<?php

use App\Models\Affaire;
use App\Models\AffaireNature;
use App\Models\FolderTech;
use App\Models\FolderTechNature;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Affaire::truncate();
       // FolderTech::truncate();
        $now = new DateTime();
        $year = $now->format("Y");
        $affaireNatures = AffaireNature::latest()->first();
        $Name = $affaireNatures->Name;
        $Abr_v = $affaireNatures->Abr_v;
        $place = 'place';
        for ($i = 0; $i < 15; $i++) {
            $ref = $Abr_v . $i . "_" . $place . "_" . $year;
            $requestData['REF'] = $ref;
            $year = rand(2000, 2020);
            $month = rand(1, 12);
            $day = rand(1, 28);

            $date = Carbon::create($year,$month ,$day , 0, 0, 0);
            $affaire = Affaire::create(['REF' => $ref,
                "PTE_KNOWN" => '0',
                "TIT_REQ" => '0',
                "place" => $place,
                "DATE_ENTRY" => '2020/03/21',
                "DATE_LAI" => '2020/04/21',
                "UNITE" => 1,
//                "ARCHIVE" => 0,
//                "isValidate" => 0,
//                "isPayed" => 0,
                "PRICE" => 10000,
                "Inter_id" => 1,
                "aff_sit_id" => 2,
                "client_id" => 1,
                "resp_id" => 1,
                "nature_name" => $Name,
                "created_at" =>$date->format('Y-m-d H:i:s'),
                "updated_at" =>$date->format('Y-m-d H:i:s'),
            ]);
        }

        $affaireNatures = FolderTechNature::latest()->first();
        $Name = $affaireNatures->Name;
        $Abr_v = $affaireNatures->Abr_v;
        $place = 'place';
        for ($i = 0; $i < 15; $i++) {
            $ref = $Abr_v . $i . "_" . $place . "_" . $year;
            $requestData['REF'] = $ref;
            $year = rand(2000, 2020);
            $month = rand(1, 12);
            $day = rand(1, 28);

            $date = Carbon::create($year,$month ,$day , 0, 0, 0);
            $affaire = FolderTech::create(['REF' => $ref,
                "PTE_KNOWN" => '0',
                "TIT_REQ" => '0',
                "place" => $place,
                "DATE_ENTRY" => '2020/03/21',
                "DATE_LAI" => '2020/04/21',
                "UNITE" => 1,
//                "ARCHIVE" => 0,
//                "isValidate" => 0,
//                "isPayed" => 0,
                "PRICE" => 10000,
                "Inter_id" => 1,
                "folder_sit_id" => 2,
                "client_id" => 1,
                "resp_id" => 1,
                "nature_name" => $Name,
                "created_at" =>$date->format('Y-m-d H:i:s'),
                "updated_at" =>$date->format('Y-m-d H:i:s'),
            ]);
        }

    }
}

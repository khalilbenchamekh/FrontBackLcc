<?php

use Illuminate\Database\Seeder;

class OrganisationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<=10;$i++){
            \Illuminate\Support\Facades\DB::table('organisations')->insert([
               "name"=>"orga".$i,
                "email"=>"orga".$i."@mail.com",
                "description"=>"test"
            ]);
        }
    }
}

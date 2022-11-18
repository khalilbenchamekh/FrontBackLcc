<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EntrustMockedDataSeeder::class);
        $this->call(CsvTableSeeder::class);
       // $this->call(UsersTableSeeder::class);
    }
}

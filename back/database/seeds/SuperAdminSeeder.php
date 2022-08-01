<?php

use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=new \App\User();
        $user->name='super';
        $user->username='super123';
        $user->email='super@super';
        $user->password=\Illuminate\Support\Facades\Hash::make('183461');
        $user->save();

        $role=new \App\Models\Role();
        $role->name="super";
        $role->display_name='Super Admin';
        $role->description='Allow to do everything';
        $role->save();

        $permission=new \App\Models\Permission();
        $permission->name="super";
        $permission->display_name='Super Admin';
        $permission->description='Allow to do everything';
        $permission->save();
    }
}

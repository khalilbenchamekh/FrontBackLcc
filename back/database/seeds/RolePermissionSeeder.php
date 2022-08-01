<?php

use App\Models\Permission;
use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $routes = array("affairenatures",
            "foldertechnatures",
            "loadtypes",
            "loads",
            "clients",
            "employees",
            "foldertechsituations",
            "affaires",
            "folderteches",
            "intermediates",
            "fees",
            "files",
            "affairesituations");
        $user = new User;
        $user->name = 'khalil1';
        $user->username = 'khalilBen1';
        $user->email = 'khalilBen1@example.com';
        $user->password = Hash::make("khalilBen1");
        $user->firstname = 'ben1';
        $user->middlename = null;
        $user->lastname = 'ben1';
        $user->gender = 'male';
        $user->birthdate = null;
        $user->address = 'Rabat1';
        $user->save();

        $actions = array("create", "edit", "read", "delete");
        for ($x = 0; $x < sizeof($routes); $x++) {
            $route = $routes[$x];

            for ($i = 0; $i < sizeof($actions); $i++) {
                $action = $actions[$i];
                $name = $route . "_" . $action;
                $display_name=$action . ' ' . $route;
                $description='Allow user to ' . $action . ' a new DB ' . $route;
                $role = new Role();
                $role->name = $name;
                $role->display_name =$display_name;
                $role->description = $description;
                $role->save();
                $create = new Permission();
                $create->name = $name;
                $create->display_name =$display_name; // optional
                $create->description =$description; // optional
                $create->save();
                $role->attachPermissions(array($create));
                $user->attachRole($role);
            }
        }


    }
}

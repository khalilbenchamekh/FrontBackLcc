<?php

use App\Models\Affaire;
use App\Models\AffaireNature;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Route;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EntrustMockedDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $create = new Permission();
        $create->name = 'create';
        $create->display_name = 'Create Record'; // optional
        $create->description = 'Allow user to create a new DB record'; // optional
        $create->save();

        $edit = new Permission();
        $edit->name = 'edit';
        $edit->display_name = 'Edit Record'; // optional
        $edit->description = 'Allow user to edit an existing DB record'; // optional
        $edit->save();
        $delete = new Permission();
        $delete->name = 'delete';
        $delete->display_name = 'Delete Record'; // optional
        $delete->description = 'Allow user to delete an existing DB record'; // optional
        $delete->save();
        $users = new Permission();
        $users->name = 'users';
        $users->display_name = 'Manage Users'; // optional
        $users->description = 'Allow user to manage system users'; // optional
        $users->save();

        $owner = new Role();
        $owner->name = "owner";
        $owner->display_name = 'Project Owner';
        $owner->description = 'User is the owner of a given project';
        $owner->save();
        $owner->attachPermissions(array($create, $edit, $delete, $users));

        $admin = new Role();
        $admin->name = "admin";
        $admin->display_name = 'Administrator';
        $admin->description = 'User has access to all system functionality expect user management';
        $admin->save();
        $admin->attachPermissions(array($create, $edit, $delete));
        $userRole = new Role();
        $userRole->name = "user";
        $userRole->display_name = 'user';
        $userRole->description = 'User can create data in the system';
        $userRole->save();
        $userRole->attachPermissions(array($create));


        $user = new User;
        $user->name = 'Jovert Palonpon';
        $user->username = 'jovert123';
        $user->email = 'jovert@example.com';
        $user->password = Hash::make("j@vert123");
        $user->firstname = 'Jovert';
        $user->middlename = 'Lota';
        $user->lastname = 'Palonpon';
        $user->gender = 'male';
        $user->birthdate = '1998-05-18';
        $user->address = 'Marungko, Angat, Bulacan';
        $user->save();
        $user->attachRole($owner);


        $user = new User;
        $user->name = 'Ian Lumbao';
        $user->username = 'ian123';
        $user->email = 'ian@example.com';
        $user->password = Hash::make("secret");

        $user->firstname = 'Ian';
        $user->middlename = null;
        $user->lastname = 'Lumbao';
        $user->gender = 'male';
        $user->birthdate = null;
        $user->address = 'Tayuman, Manila, Metro Manila';
        $user->save();
        $user->attachRole($admin);


        $user = new User;
        $user->name = 'khalil';
        $user->username = 'khalilBen';
        $user->email = 'khalilBen@example.com';
        $user->password = Hash::make("khalilBen");
        $user->firstname = 'ben';
        $user->middlename = null;
        $user->lastname = 'ben';
        $user->gender = 'male';
        $user->birthdate = null;
        $user->address = 'Rabat';
        $user->save();
        $user->attachRole($userRole);

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
            "charges",
            "typeCharge",
            "EtatFacture",
            "GreatConstructionSites",
            "Cadastralconsultation",
            "affairesituations");


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
            }
        }
        foreach ($routes as $value) {
            Route::create([
                'name' => $value
            ]);
        };



    }
}

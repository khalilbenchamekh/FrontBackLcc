<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\Route;
use App\Organisation;
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
        $permission = Permission::where('name','like','super')->first();
        if (is_null($permission)) {
            $permission=new Permission();
            $permission->name="super";
            $permission->display_name='Super Admin';
            $permission->description='Allow to do everything';
            $permission->save();
        }

        $role = Role::where('name','like','owner')->first();
        if (is_null($role)) {
            $role=new Role();
            $role->name="owner";
            $role->display_name='owner organisation';
            $role->description='Allow to do everything in his organsiation';
            $role->save();
            $role->attachPermissions(array($permission));
        }

        $super = User::where('name','like','super')->first();
        if (is_null($super)) {
            $super=new User();
            $super->name='super';
            $super->username='super123';
            $super->email='super@super';
            $super->password = Hash::make('183461');
            $super->save();
            $super->attachRole($role);
        }

        $organisation = Organisation::where('name','like','lcc')->first();
        if (is_null($organisation)) {
            $organisation = new Organisation();
            $organisation->name = 'lcc';
            $organisation->ICE = 'ICE';
            $organisation->cto = $super->id;
            $organisation->emailOrganisation = "lcc@mail.com";
            $organisation->description = 'lcc consulting'; // optional
            $organisation->save();
            $super->organisation_id = $organisation->id;
            $super->save();
        }

        $create = Permission::where('name','like','create')->first();
        if (is_null($create)) {
            $create = new Permission();
            $create->name = 'create';
            $create->display_name = 'Create Record'; // optional
            $create->description = 'Allow user to create a new DB record'; // optional
            $create->save();
        }

        $edit = Permission::where('name','like','edit')->first();
        if (is_null($edit)) {
            $edit = new Permission();
            $edit->name = 'edit';
            $edit->display_name = 'Edit Record'; // optional
            $edit->description = 'Allow user to edit an existing DB record'; // optional
            $edit->save();
        }

        $delete = Permission::where('name','like','delete')->first();
        if (is_null($delete)) {
            $delete = new Permission();
            $delete->name = 'delete';
            $delete->display_name = 'Delete Record'; // optional
            $delete->description = 'Allow user to delete an existing DB record'; // optional
            $delete->save();
        }

        $users = Permission::where('name','like','users')->first();
        if (is_null($users)) {
            $users = new Permission();
            $users->name = 'users';
            $users->display_name = 'Manage Users'; // optional
            $users->description = 'Allow user to manage system users'; // optional
            $users->save();
        }

        $owner = Role::where('name','like','owner')->first();
        if (is_null($owner)) {
            $owner = new Role();
            $owner->name = "owner";
            $owner->display_name = 'Project Owner';
            $owner->description = 'User is the owner of a given project';
            $owner->save();
            $owner->attachPermissions(array($create, $edit, $delete, $users));
        }

        $admin = Role::where('name','like','admin')->first();
        if (is_null($admin)) {
            $admin = new Role();
            $admin->name = "admin";
            $admin->display_name = 'Administrator';
            $admin->description = 'User has access to all system functionality expect user management';
            $admin->save();
            $admin->attachPermissions(array($create, $edit, $delete));
        }

        $userRole = Role::where('name','like','user')->first();
        if (is_null($admin)) {
            $userRole = new Role();
            $userRole->name = "user";
            $userRole->display_name = 'user';
            $userRole->description = 'User can create data in the system';
            $userRole->save();
            $userRole->attachPermissions(array($create));
        }
        $user = User::where('name','like','Jovert Palonpon')->first();
        if (is_null($user)) {
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
            $user->organisation_id = $organisation->id;
            $user->save();
            $user->attachRole($owner);
        }

        $user = User::where('name','like','Ian Lumbao')->first();
        if (is_null($user)) {
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
        $user->organisation_id = $organisation->id;
        $user->save();
        $user->attachRole($admin);
        }

        $user = User::where('name','like','khalil')->first();
        if (is_null($user)) {
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
            $user->organisation_id = $organisation->id;
            $user->save();
            $user->attachRole($userRole);
        }

        $resRoutes = Route::where('name','like','affair'.'%')->first();
        if (is_null($resRoutes)) {
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
            "Mission",
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
}

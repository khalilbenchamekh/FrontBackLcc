<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as UserResource;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function register(RegisterRequest $request)
    {
        $firstname = $request->input('firstname');
        $middlename = $request->input('middlename');
        $lastname = $request->input('lastname');

        $role=Role::where('name', '=',$request->input('role'))->first();
        $user = new User;
        $user->name = "{$firstname} {$middlename} {$lastname} {$request->input('name')}";
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->password);
        $user->firstname = $firstname;
        $user->middlename = $middlename;
        $user->lastname = $lastname;
        $user->gender = $request->input('gender');
        $user->birthdate = $request->input('birthdate');
        $user->address =$request->input('address');
        $user->save();
        $user->attachRole($role);
        $data = new UserResource($user);

        return response()->json(compact('data'));

    }
    /**
     * Save Auth Token.
     *
     * @param string $token
     * @param App\User $user
     *
     * @return bool
     */
    protected function saveAuthToken(string $token, User $user) : bool
    {
        $user->auth_token = $token;
        $user->last_signin = now();

        return $user->update();
    }

}

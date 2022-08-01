<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function connexion(){
        return view('connexion');
    }
    public function login(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'email'=>"required",
            'password'=>'required|min:3'
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
        //$credentials = ['email'=>$request->input('email'),"password"=>$request->input('password')];
        //$credentials=$request->only('email', 'password');
   // $user=DB::table('users')->select(['*'])->where('email',"=",$request->input("email"))->where('password',"=",$request->input("password"))->get();
        $user=User::Where('email',"=",$request->input("email"))->where('password',"=",$request->input("password"))->first();
        try {
                if($user instanceof User){
                    if (! $token = JWTAuth::fromUser($user)) {
                        return response()->json(['error' => 'invalid_credentials'], 400);
                }
            }

        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
}

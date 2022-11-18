<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Resource\ProfileResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordMainRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\Email\ISendEmail;
use App\User;
use Carbon\Exceptions\Exception;
use Illuminate\Hashing\BcryptHasher;
use Tymon\JWTAuth\Exceptions\JWTException;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private $sendEmail;
    public function __construct(ISendEmail $sendEmail)
    {
        $this->sendEmail=$sendEmail;
    }
    /**
     * Login
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
        // Get User by email
         $user = User::where('email', $request->email)->first();
        // Return error message if user not found.
        if (!$user) return response()->json(['error' => 'User not found.'], Response::HTTP_NOT_FOUND);

        // Account Validation
        if (!(new BcryptHasher)->check($request->input('password'), $user->password)) {
            // Return Error message if password is incorrect
            return response()->json(['error' => 'Email or password is incorrect. Authentication failed.'], Response::HTTP_UNAUTHORIZED);
        }

        // Get email and password from Request
        $credentials = [
            'email'=>$request->input('email'),
            'password'=>$request->input('password')
        ];
        try {
            // Login Attempt
            if (!$token = JWTAuth::attempt($credentials)) {
                // Return error message if validation failed
                return response()->json(['error' => 'invalid_credentials'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            // Return Error message if cannot create token.
           // return $credentials = $request->only('email', 'password');
            return response()->json(['error' => 'could_not_create_token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $customClaims = ['Role' => $user->roles !== [] ? $user->roles[0]->name : 'user'];
        $token = JWTAuth::attempt($credentials, $customClaims);
        $data = new ProfileResource($user);
        return response()->json(
            compact('token','data')
        );
    }

    public function checkEmailForResetPassword(ForgotPasswordMainRequest $request){
        try {
         // Get User by email
         $user = User::where('email', $request->email)->first();
         // Return error message if user not found.
         if (!$user) return response()->json(['error' => 'User not found.'], 404);
        $faker = new Faker();
        $password = $faker->unique()->password();
        $user->password = Hash::make($password);
        $user->save();
        $message = "Reset your Passowrd";
        $this->sendEmail->ResetPassword($request->email,$message);
        return response()->json(['data' => 'check_your_email']);
        } catch (Exception $e) {
            return response()->json(['error' => 'could_not_Send_email'], 500);
        }
    }

    public function ResetPassword(ForgotPasswordRequest $request)
    {
            // Get User by email
            $user = User::where('email', $request->email)->first();
            // Return error message if user not found.
            if (!$user) return response()->json(['error' => 'User not found.'], 404);
                // Account Validation
            if (!(new BcryptHasher)->check($request->input('password'), $user->password)) {
                // Return Error message if password is incorrect
                return response()->json(['error' => 'Email or password is incorrect. Authentication failed.'], 401);
            }
              // Get email and password from Request
            $credentials = $request->only('email', 'newPassword');
            try {
                // Login Attempt
                if (!$token = JWTAuth::attempt($credentials)) {
                    // Return error message if validation failed
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }
            } catch (JWTException $e) {
                // Return Error message if cannot create token.
            // return $credentials = $request->only('email', 'password');
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            $customClaims = ['Role' => $user->roles !== [] ? $user->roles[0]->name : 'user'];
            $token = JWTAuth::attempt($credentials, $customClaims);
            $data = new ProfileResource($user);
            return response()->json(
                compact('token','data')
            );
    }

    public function refresh()
    {

        try {
            // Login Attempt
            if (!$token = JWTAuth::refresh()) {
                return response()->json(['error' => 'invalid_credentials'], 401);

            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);

        }
        return $token;
    }


}

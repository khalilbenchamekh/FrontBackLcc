<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Resource\ProfileResource;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{

   public function login(LoginRequest $request): JsonResponse
   {
       return (new ProfileResource(auth()->user()))
           ->response()
           ->withCookie(
               'token',
               auth()->getToken()->get(),
               config('jwt.ttl'),
               '/'
           );
   }
}

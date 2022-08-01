<?php

namespace App\Http\Middleware\Web;

use App\Http\Controllers\Web\AuthController;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user=auth()->user();
        if (!$user->hasRole(['super'])){
            return response()->json(['error'=>1,"message"=>"you can't"],Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}

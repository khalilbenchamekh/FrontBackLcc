<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 05/06/2020
 * Time: 17:27
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = JWTAuth::user();
        if ($user) {
            $expiresAt = Carbon::now()->addMinutes(1);
            Cache::put('user-is-online-' . $user->id, true, $expiresAt);
        }
        return $next($request);
    }
}

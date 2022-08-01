<?php
//
//namespace App\Http\Middleware;
//
//use Closure;
//
//class Cors
//{
//    public function handle($request, Closure $next)
//    {
//        $response = $next($request);
//
//        $response->headers->set('Access-Control-Allow-Origin', '*');
//        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT, OPTIONS, HEAD, PATCH');
//        $response->headers->set('Access-Control-Allow-Credentials', 'false');
//        $response->headers->set('Access-Control-Allow-Headers', 'Range, Accept, Application,Authorization,DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Set-Cookie');
//        return $response;
//    }
//}


namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin' , '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
        
        return $response;
    }
}


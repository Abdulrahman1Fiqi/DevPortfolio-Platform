<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        if(! $request->user()){
            return redirect()->route('login');
        }


        if($request->user()->role !== $role){

            return match($request->user()->role ){
            'admin'=> redirect()->route('admin.dashboard'),
            'recruiter'=> redirect()->route('recruiter.dashboard'),
            'developer'=> redirect()->route('developer.dashboard'),
         };
        }


        return $next($request);
    }
}

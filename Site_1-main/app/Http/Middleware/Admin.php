<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if not logged in, redirect to login page
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->admin) {
            return $next($request);
        }
        return abort(403, 'Enkel toegankelijk voor admins.');
    }
}

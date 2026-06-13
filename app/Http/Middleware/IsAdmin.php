<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND has the 'admin' role
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Let them through
        }

        // If they fail the check, boot them to the homepage with an error
        return redirect('/')->with('message', 'Access Denied: You do not have admin privileges.');

        
        
        // Alternatively, you can throw a 403 Forbidden error:
        // abort(403, 'Unauthorized action.');
    
    }
}

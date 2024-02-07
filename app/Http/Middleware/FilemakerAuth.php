<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class FilemakerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve credentials from session or request
        $username = $request->session()->get('username',null);
        $password = $request->session()->get('password',null);

        if (!$request->session()->has('filemaker_token') || !$username || !$password) {
            // Redirect to a specific route if age is less than 18
            return redirect('login');
        }


        // Dynamically set the FileMaker database connection credentials
//        Config::set('database.connections.filemaker.username', $username);
//        Config::set('database.connections.filemaker.password', $password);
        config([
            'database.connections.filemaker.username' => $username,
            'database.connections.filemaker.password' => $password
        ]);
        // If age is 18 or above, proceed with the request
        return $next($request);
    }
}

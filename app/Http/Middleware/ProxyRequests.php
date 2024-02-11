<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class ProxyRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $imageUrl = urldecode($request->query('url'));

            if (is_null($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                // URL is not valid or not provided
                return response()->json(['error' => 'Invalid or missing URL','url' => $imageUrl], 400);
            }
            $serializedCookies = $request->session()->get('fm_image_cookie', null);

            if ($serializedCookies) {
                // Unserialize the cookies to convert them back to an array
                $cookies = unserialize($serializedCookies);
                // Use the cookies for subsequent HTTP requests
                $response = Http::withCookies($cookies, config('database.connections.filemaker.host'))->get($imageUrl);
                if ($response->successful()) {
                    return response($response->body())
                        ->header('Content-Type', $response->header('Content-Type'));
                }
            }
            $cookiesArray = $this->getSessionCookie($imageUrl);
            $request->session()->put(['fm_image_cookie' => $cookiesArray]);
            return Redirect::route('proxy', ['url' => $imageUrl]);
        } catch (\Exception $e) {
            // Handle the exception, log error, and return an appropriate response
            return response()->json(['error' => 'Image could not be retrieved'], 502); // Bad Gateway
        }
        return response('Image could not be retrieved', 404);
    }

    private function getSessionCookie($imageUrl) {
        $response = Http::get($imageUrl);

        if ($response->successful()) {
            $cookieJar = $response->cookies(); // This gets the CookieJar object
            $cookiesArray = [];
            // Convert cookies from CookieJar to an associative array
            foreach ($cookieJar as $cookie) {
                $cookiesArray[$cookie->getName()] = $cookie->getValue();
            }
            return serialize($cookiesArray);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Response as LaravelResponse;


class PlayerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
//        $request->session()->forget('http_response_cookies_fm_image');
        $players = Player::all();
        return Inertia::render('Players/Index', ['players' => $players]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function imageProxy(Request $request)
    {

        $imageUrl = urldecode($request->query('url'));

        if (is_null($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            // URL is not valid or not provided
            return response()->json(['error' => 'Invalid or missing URL','url' => $imageUrl], 400);
        }
        $serializedCookies = $request->session()->get('http_response_cookies_fm_image', null);
        Log::info('cookies: {cookies}', ['cookies' => $serializedCookies]);
        if ($serializedCookies) {
            // Unserialize the cookies to convert them back to an array
            $cookies = unserialize($serializedCookies);

            // Use the cookies for subsequent HTTP requests
            $response = Http::withCookies($cookies, config('database.connections.filemaker.host'))->get($imageUrl);
            if ($response->successful()) {
                return response($response->body())
                    ->header('Content-Type', $response->header('Content-Type'));
            }
        } else {
            $response = Http::get($imageUrl);

            if ($response->successful()) {
                $cookieJar = $response->cookies(); // This gets the CookieJar object
                $cookiesArray = [];
                // Convert cookies from CookieJar to an associative array
                foreach ($cookieJar as $cookie) {
                    $cookiesArray[$cookie->getName()] = $cookie->getValue();
                }
                // Access the response content
                $request->session()->put(['http_response_cookies_fm_image' => serialize($cookiesArray)]);
                Log::info('url: {imageUrl}', ['imageUrl' => $imageUrl]);
                return Redirect::route('players.imageProxy', ['url' => $imageUrl]);
//                return redirect()->route('players.imageProxy', ['url' => $imageUrl]);
            }
        }
        return response('Image could not be retrieved', 404);

    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        return Inertia::render('Players/Show', ['player' => $player]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

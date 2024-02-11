<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Http\File;
use Inertia\Inertia;
use Inertia\Response;


class PlayerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
//        $request->session()->forget(['fm_image_cookie']);
        $players = Player::all();
        return Inertia::render('Players/Index', ['players' => $players]);
    }

    public function create()
    {
        return Inertia::render('Players/Show');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255|nullable',
            'age' => 'integer|nullable',
            'contact' => 'string|max:255|nullable',
            'team_name' => 'string|max:255|nullable',
            'image' => 'nullable|image|max:2048', // Validate the image
        ]);

        unset($validatedData['image']);
        if ($request->hasFile('image')) {
            // Assign the base64 string to the 'photo' field (or whichever field you use in FileMaker)
            $validatedData['image'] = $request->file('image');
        }
        dd($validatedData);

        $player = Player::create($validatedData);

        return redirect()->route('players.index');
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
    public function update(Request $request, Player $player)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255|nullable',
            'age' => 'integer|nullable',
            'contact' => 'string|max:255|nullable',
            'team_name' => 'string|max:255|nullable',
            'image' => 'nullable|image|max:2048', // Validate the image
        ]);

        unset($validatedData['image']);
        if ($request->hasFile('image')) {
            // Assign the base64 string to the 'photo' field (or whichever field you use in FileMaker)
            $validatedData['image'] = $request->file('image');
        }
        // Update player with validated data
        $player->update($validatedData);

        return redirect()->route('players.index')->with('message', 'Player updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

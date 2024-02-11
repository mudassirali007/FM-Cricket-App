<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;
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
//        dd($request->session()->all());
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
    public function store(PlayerRequest $request)
    {
        $validatedData = $this->getValidatedData($request);

        Player::create($validatedData);

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
    public function update(PlayerRequest $request, Player $player)
    {
        $validatedData = $this->getValidatedData($request);

        // Update player with validated data
        $player->update($validatedData);

        return redirect()->route('players.index')->with('message', 'Player updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $player->delete();

        return redirect()->route('players.index')->with('success', 'Player deleted successfully');
    }

    /**
     * @param PlayerRequest $request
     * @return mixed
     */
    public function getValidatedData(PlayerRequest $request): mixed
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $validatedData['image'] = [$image, $image->getClientOriginalName()];
        } else {
            unset($validatedData['image']);
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $validatedData['document'] = [$document, $document->getClientOriginalName()];
        } else {
            unset($validatedData['document']);
        }
        return $validatedData;
    }
}

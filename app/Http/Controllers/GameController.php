<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\User;
use App\Models\Round;
use Illuminate\Validation\Rules;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all();
        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'max_round' => ['required', 'integer'],
            'delivery_time' => ['required', 'string', 'max:255'],
            'owner_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the game without the game_owner_id
        $game = Game::create([
            'name' => $request->name,
            'slug' => $this->createUniqueSlug($request->name),
            'current_round' => 1,
            'max_round' => $request->max_round,
            'unit_fee' => 0.5,
            'backlog_fee' => 1.0,
            'delivery_time' => $request->delivery_time,
            'game_owner_id' => null, //null for now
        ]);

        // Create the user with the game_id
        $user = User::create([
            'name' => $request->owner_name,
            'password' => Hash::make($request->password),
            'is_observer' => false, // Owner is a player for now
            'game_id' => $game->id
        ]);

        $game->game_owner_id = $user->id;
        $game->save();

        // Fire the registered event
        event(new Registered($user));

        // Log in the newly created user
        Auth::login($user);

        $this->startGame($game);

        return redirect()->route('games.show', $game)->with('success', 'Game added successfully.');
    }

    private function startGame(Game $game)
    {
        $gameId = $game->id;

        //array of possible order amounts
        $customerOrderAmount = array(100, 150, 200, 250, 300, 350, 400, 450, 500,600, 700, 800, 900, 1000);

        //picking a random value of array
        $customerOrder = $customerOrderAmount[array_rand($customerOrderAmount, 1)];

        //check if row already exists for game (it shouldn't)
        $gameExists = Round::where('game_id', $gameId)->first();

        //if not, create it
        if (!$gameExists) {
            Round::create([
                'game_id' => $gameId,
                'current_round' => 1,
                'current_stock' => 800, //default stock set to 800, open to change
                'customer_orders' => $customerOrder, //inserting picked random value
                'backlog' => 0,
                'total_cost' => 0
            ]);
        }
    }

    private function createUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = Game::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }


    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }

    public function showHistory(Game $game)
    {
        return view('games.history', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        return view('games.edit', compact('game'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'current_round' => 'required|integer',
            'max_round' => 'required|integer',
            'unit_fee' => 'required|numeric|between:0.00,99.99',
            'backlog_fee' => 'required|numeric|between:0.00,99.99',
            'delivery_time' => 'required|string|max:255',
        ]);

        $game->update($request->all());
        // dd($game);
        //return view('games.show', compact('game'));
        return redirect()->route('games.show', $game)->with('success', 'Game updated successfully.');
        // return redirect()->route('games.index')->with('success', 'Game updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('games.index')->with('success', 'Game deleted successfully.');
    }
}

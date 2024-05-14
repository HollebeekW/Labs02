<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Game\StoreGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();

        return view('games.index', compact('games'));
    }

    public function create()
    {
        return view('games.create');
    }

    public function store(StoreGameRequest $request)
    {
        $request->validate([
            'name' => 'required',
            'max_rounds' => 'required|min:1|max:10',
            'unit_fee' => 'required|min:1|max:10',
            'backlog_fee' => 'required|min:1|max:10',
            'delivery_time' => 'required|min:1|max:10',
        ]);

        $input = $request->all();

        $game = Game::create($input);

        //redirect to created games' page
        return redirect()->route('games.show', $game->id);
    }

    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }

    public function edit(Game $game)
    {
        return view('games.edit', compact('game'));
    }

    public function update(UpdateGameRequest $request, Game $game)
    {
        $request->validate([
            'name' => 'required',
            'max_rounds' => 'required|min:1|max:10',
            'unit_fee' => 'required|min:1|max:10',
            'backlog_fee' => 'required|min:1|max:10',
            'delivery_time' => 'required|min:1|max:10',
        ]);

        $input = $request->all();

        $game->update($input);

        //redirect to created games' page
        return redirect()->route('games.show', $game->id);
    }
}

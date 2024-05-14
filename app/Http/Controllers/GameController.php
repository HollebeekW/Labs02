<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Game\StoreDataRequest;
use App\Http\Requests\Game\StoreGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Models\Game;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        //create unique token
        $creatorToken = Str::random(10);

        $request->validate([
            'name' => 'required',
            'max_rounds' => 'required|min:1|max:10',
            'unit_fee' => 'required|min:1|max:10',
            'backlog_fee' => 'required|min:1|max:10',
            'delivery_time' => 'required|min:1|max:10',
        ]);

        $input = $request->all();
        $input['creator_token'] = $creatorToken;

        $game = Game::create($input);

        //store created token in session
        session(['creator_token' => $creatorToken]);

        //redirect to created games' page
        return redirect()->route('games.show', $game->id);
    }

    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }

    public function edit(Game $game)
    {
        if (session('creator_token') !== $game->creator_token) {
            abort(403);
        }
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

    public function startGame(Game $game)
    {
        $gameId = $game->id;

        //check if row already exists for game
        $gameExists = Round::where('game_id', $gameId)->first();

        //if not, create it
        if (!$gameExists) {
            Round::create([
                'game_id' => $gameId,
                'current_round' => 1,
                'current_stock' => 100
            ]);
        }


        return view('games.game', compact('game'));
    }

    public function nextRound(StoreDataRequest $request, Game $game)
    {
        $latestRound = $game->rounds()->latest()->first();

        //Check if current round is less than max rounds
        if ($latestRound && $latestRound->current_round < $game->max_rounds)
        {
            //increment round by 1
            $nextRound = $latestRound->current_round + 1;

            $addedStock = $request->validate([
                'stock' => 'required|min:1|max:1000',
            ]);

            $newStock = $addedStock['stock'] + $latestRound->current_stock;

            //insert new row into database
            $game->rounds()->create([
                'current_round' => $nextRound,
                'current_stock' => $newStock,
            ]);
        }
        else
        {
            dd("Max Rondes bereikt");
        }
        return view('games.game', compact('game'));
    }
}

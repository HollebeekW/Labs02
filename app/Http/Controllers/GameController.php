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
        //check if token in session is equal to token stored in database
        if (session('creator_token') !== $game->creator_token) {
            abort(403); //return 403 error if token is not equal
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
                'current_stock' => 100, //default stock set to 100, open to change
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

            //new stock
            $addedStock = $request->validate([
                'stock' => 'required|min:1|max:1000',
            ]);

            //Add new stock to already existing stock
            $newStock = $addedStock['stock'] + $latestRound->current_stock;

            //insert new row into database
            $game->rounds()->create([
                'current_round' => $nextRound,
                'current_stock' => $newStock,
            ]);
        }
        else
        {
            //dd for now, will be changed
            dd("Max Rondes bereikt");
        }
        return view('games.game', compact('game'));
    }

    public function results(Game $game)
    {
        return view('games.results', compact('game'));
    }

    public function destroy(Game $game)
    {
        //delete game and all rounds
        Game::where('id', $game->id)->delete();
        Round::where('game_id', $game->id)->delete();

        //return to games index
        $games = Game::all();
        return view('games.index', compact('games'));

    }
}

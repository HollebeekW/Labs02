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
use Ramsey\Uuid\Type\Time;
use function Symfony\Component\Translation\t;

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
        ]);

        $input = $request->all();

        $game->update($input);

        return redirect()->route('games.show', $game->id);
    }

    public function startGame(Game $game)
    {
        $gameId = $game->id;

        //array of possible order amounts
        $customerOrderAmount = array(100, 150, 200, 250, 300, 350, 400, 450, 500,600, 700, 800, 900, 1000);

        //picking a random value of array
        $customerOrder = $customerOrderAmount[array_rand($customerOrderAmount, 1)];

        //check if row already exists for game
        $gameExists = Round::where('game_id', $gameId)->first();

        //if not, create it
        if (!$gameExists) {
            Round::create([
                'game_id' => $gameId,
                'current_round' => 1,
                'current_stock' => 0, //default stock set to 0, open to change
                'customer_orders' => $customerOrder, //inserting picked random value
                'backlog' => 0,
                'total_cost' => 0
            ]);
        }

        $costResults = 0;

        return view('games.game', compact('game', 'costResults'));
    }

    public function nextRound(StoreDataRequest $request, Game $game)
    {
        //get information from current round
        $latestRound = $game->rounds()->latest()->first();

        //get stock from current round
        $currentStock = $game->rounds()->latest()->first()->current_stock;

        //get backlog from current round
        $roundBacklog = $game->rounds()->latest()->first()->backlog;

        //Increment round by 1
        $nextRound = $latestRound->current_round + 1;

        //Add ordered stock to next round
        $orderedStock = $request->validate([
            'stock' => 'required|min:0|max:1000'
            ])['stock'];

        //Retrieve amount of items ordered by customers in round 1
        $customerOrders = $latestRound->customer_orders;

        //Add new stock to already existing stock then subtract customer orders
        $newStock = $orderedStock + $latestRound->current_stock - $customerOrders;

        //define backlog, so it can be used for inserting row
        $backlog = 0;

        //if new stock is negative, multiply by -1 to make it positive, then store it in backlog
        if ($newStock < 0) {
            $backlog = $newStock * -1;
        }

        //new customer order amount
        $customerOrderAmount = array(100, 150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000);
        $customerOrder = $customerOrderAmount[array_rand($customerOrderAmount, 1)]; //pick one random value from above array

        //cost
        if ($currentStock >= 0) {
            $totalCost = $orderedStock * $game->unit_fee; //if no backlog exists, calculate normally
        } else {
            $totalCost = (($roundBacklog * $game->backlog_fee) + (($orderedStock - $roundBacklog) * $game->unit_fee)); //adjust for backlog
        }

        //don't calculate cost if no units are ordered
        if($orderedStock == 0) {
            $totalCost = 0;
        }

        if ($latestRound->current_round != $game->max_rounds) {
            //insert new row into database
            $game->rounds()->create([
                'current_round' => $nextRound,
                'current_stock' => $newStock,
                'ordered_stock' => $orderedStock,
                'customer_orders' => $customerOrder,
                'backlog' => $backlog,
                'total_cost' => $totalCost
            ]);

        } else {
            $game->rounds()->create([
                'current_round' => $nextRound,
                'current_stock' => $newStock,
                'ordered_stock' => $orderedStock,
                'customer_orders' => 0,
                'backlog' => $backlog,
                'total_cost' => $totalCost
            ]);
        }

        $costResults = $game->rounds()->sum('total_cost');

        return view('games.game', compact('game', 'costResults'));
    }

    public function showHistory(Game $game)
    {
        return view('games.history', compact('game'));
    }

    public function showResults(Game $game)
    {
        //show stock per round
        $stockResults = Round::where('game_id', '=', $game->id)->sum('ordered_stock');

        $costResults = Round::where('game_id', '=', $game->id)->sum('total_cost');

        $backlogResults = Round::where('game_id', '=', $game->id)->sum('backlog');

        $customerOrderResults = Round::where('game_id', '=', $game->id)->sum('customer_orders');

        return view('games.results', compact('game', 'stockResults', 'costResults', 'backlogResults', 'customerOrderResults'));
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

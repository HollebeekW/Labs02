<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserOrder;
use App\Models\GameOrder;
use App\Models\Game;
use App\Models\Round;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request, Game $game)
    {
        // Validate the incoming request data
        $request->validate([
            'order_amount' => 'required|integer|min:0',
        ]);

        // Required variables to check if order already has been made
        $user = Auth::user();
        $currentRound = $game->current_round;

        // Check if the user has already made an order for the current round
        $existingOrder = $user->userOrders()
            ->where('round_number', $currentRound)
            ->first();

        if($existingOrder) {
            return redirect()->route('games.show', $game)
                ->withErrors(['order_amount' => 'You have already placed an order for this round.']);
        }

        // Create a new user order
        $userOrder = new UserOrder();
        $userOrder->user_id = $user->id;
        $userOrder->order_amount = $request->order_amount;
        $userOrder->round_number = $currentRound;
        $userOrder->save();

        // Check if all users have submitted orders for the current round
        $totalUsers = $game->users()->count();
        $roundUserOrders = $game->userOrders()
            ->where('round_number', $currentRound);

//        dd(var_dump($totalUsers, $roundUserOrders));

        if($totalUsers == $roundUserOrders->count()) {
            // Create a new game order
            $avarageOrderAmount = $roundUserOrders->avg('order_amount');

            GameOrder::create([
                'game_id' => $game->id,
                'order_amount' => $avarageOrderAmount,
                'round_number' => $currentRound,
            ]);


            $this->nextRound($game);

            // Proceed to next round
            $game->current_round += 1;
            $game->save();

            return redirect()->route('games.show', $game)->with('success', 'Game progressed to the next round');

        }

        // Redirect back to the game show page with a success message
        return redirect()->route('games.show', $game)->with('success', 'Order placed successfully.');
    }

    private function nextRound(Game $game)
    {
        // Get information from previous round
        $latestRound = $game->latestRound();

        // Get stock from current round
        $currentStock = $latestRound->current_stock;
        // Delivered stock
        $deliveredStock = $game->deliveredGameOrder();
        if($deliveredStock) {
            $currentStock += $deliveredStock->order_amount;
        }

        $totalDemand = $latestRound->customer_orders + $latestRound->backlog;

        // Calculate fulfilled orders and new backlog
        $fulfilledOrders = min($currentStock, $totalDemand);

        $newBacklog = max(0, $totalDemand - $fulfilledOrders);

        // Update current stock
        $newStock = max(0, $currentStock - $fulfilledOrders);

        // Calculate costs
        $unitFeeCost = $newStock * $game->unit_fee;
        $backlogFeeCost = $newBacklog * $game->backlog_fee;
        $totalCost = $unitFeeCost + $backlogFeeCost;


        //new customer order amount
        $customerOrderAmount = array(100, 150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000);
        $customerOrder = $customerOrderAmount[array_rand($customerOrderAmount, 1)]; //pick one random value from above array

        Round::create([
            'game_id' => $game->id,
            'current_round' => $latestRound->current_round + 1,
            'current_stock' => $newStock,
            'customer_orders' => $customerOrder,
            'backlog' => $newBacklog,
            'total_cost' => $totalCost
        ]);


    }
}

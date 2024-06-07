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
            'order_amount' => 'required|integer|min:0|max:99999', //max of 99999 to prevent database crash on orders like 9999999999999
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

            $avarageOrderAmount = $roundUserOrders->avg('order_amount');

            $this->createNextOrders($game, $avarageOrderAmount);

            $this->nextRound($game);


            $game->incrementRound();

            return redirect()->route('games.show', $game)->with('success', 'Game progressed to the next round');

        }

        // Redirect back to the game show page with a success message
        return redirect()->route('games.show', $game)->with('success', 'Order placed successfully.');
    }

    private function createNextOrders(Game $game, float $wholesalerOrder)
    {
        $currentRoundNumber = $game->current_round;

        $currentRound = $game->currentRound();

        $previousOrder = $game->previousOrder();


       // Manufacturer order will always stay at a constant number.

        // Tries to stay at 800 stock
        $distributorOrder = max(0, 800 + 500 - $currentRound->manufacturer_send + $previousOrder->wholesaler_order - $currentRound->distributor_stock + $currentRound->distributor_backlog);

        // The order for the wholesaler already has a definition

        // Tries to stay at 800 stock
        $retailerOrder = max(0, 800 + 500 - $currentRound->wholesaler_send + $previousOrder->customer_order - $currentRound->retailer_stock + $currentRound->retailer_backlog);

        $customerOrderAmount = array(100, 150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000);
        $customerOrder = $customerOrderAmount[array_rand($customerOrderAmount, 1)]; //pick one random value from above array

        GameOrder::create([
            'game_id' => $game->id,
            'round_number' => $currentRoundNumber,
            'manufacturer_order' => 0, // Produced goods
            'distributor_order' => $distributorOrder,
            'wholesaler_order' => $wholesalerOrder,
            'retailer_order' => $retailerOrder,
            'customer_order' => $customerOrder,
        ]);



    }
    private function nextRound(Game $game)
    {
        // Get information from previous round
        $latestRound = $game->currentRound();
        // Get delivered round (probably the same as current round)
        $deliveredRound = $game->deliveredRound();
        // Get information from the latest order
        $latestOrder = $game->previousOrder();

        // Calculate stocks after getting delivery
        if ($deliveredRound) {
            $manufacturerStock = $latestRound->manufacturer_stock + 600;
            $distributorStock  = $latestRound->distributor_stock  + $deliveredRound->manufacturer_send;
            $wholesalerStock   = $latestRound->wholesaler_stock   + $deliveredRound->distributor_send;
            $retailerStock     = $latestRound->retailer_stock     + $deliveredRound->wholesaler_send;
        } else {
            $manufacturerStock = $latestRound->manufacturer_stock + 600;
            $distributorStock  = $latestRound->distributor_stock  + 400;
            $wholesalerStock   = $latestRound->wholesaler_stock   + 400;
            $retailerStock     = $latestRound->retailer_stock     + 400;
        }

        // Calculate total demand
        $manufacturerDemand = $latestRound->manufacturer_backlog + $latestOrder->distributor_order;
        $distributorDemand  = $latestRound->distributor_backlog  + $latestOrder->wholesaler_order;
        $wholesalerDemand   = $latestRound->wholesaler_backlog   + $latestOrder->retailer_order;
        $retailerDemand     = $latestRound->retailer_backlog     + $latestOrder->customer_order;

        // Calculate fulfilled demand
        $manufacturerSend = min($manufacturerStock, $manufacturerDemand);
        $distributorSend  = min($distributorStock,  $distributorDemand);
        $wholesalerSend   = min($wholesalerStock,   $wholesalerDemand);
        $retailerSend     = min($retailerStock,     $retailerDemand);

        // Calculate new backlog
        $manufacturerBacklog = max(0, $manufacturerDemand - $manufacturerSend);
        $distributorBacklog  = max(0, $distributorDemand - $distributorSend);
        $wholesalerBacklog   = max(0, $wholesalerDemand - $wholesalerSend);
        $retailerBacklog     = max(0, $retailerDemand - $retailerSend);

        // Calculate new stock
        $manufacturerStock = max(0, $manufacturerStock - $manufacturerSend);
        $distributorStock  = max(0, $distributorStock - $distributorSend);
        $wholesalerStock   = max(0, $wholesalerStock - $wholesalerSend);
        $retailerStock     = max(0, $retailerStock - $retailerSend);

        Round::create([
            'game_id' => $game->id,
            'current_round' => $latestRound->current_round + 1,
            'distributor_backlog' => $distributorBacklog,
            'distributor_stock' => $distributorStock,
            'distributor_send' => $distributorSend,
            'manufacturer_backlog' => $manufacturerBacklog,
            'manufacturer_stock' => $manufacturerStock,
            'manufacturer_send' => $manufacturerSend,
            'wholesaler_backlog' => $wholesalerBacklog,
            'wholesaler_stock' => $wholesalerStock,
            'wholesaler_send' => $wholesalerSend,
            'retailer_backlog' => $retailerBacklog,
            'retailer_stock' => $retailerStock,
            'retailer_send' => $retailerSend,
            'customer_orders' => 0
        ]);

    }
}

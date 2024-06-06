<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'current_round',
        'distributor_backlog',
        'distributor_stock',
        'distributor_send',
        'manufacturer_backlog',
        'manufacturer_stock',
        'manufacturer_send',
        'wholesaler_backlog',
        'wholesaler_stock',
        'wholesaler_send',
        'retailer_backlog',
        'retailer_stock',
        'retailer_send',
        'customer_orders', // Shouldn't have implementations
        'total_cost', // Not used right now
        'round_time' // Not used right now
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function totalCost()
    {
        $stockCost = $this->manufacturer_stock + $this->distributor_stock + $this->wholesaler_stock + $this->retailer_stock;
        $stockCost *= $this->game()->first()->unit_fee;

        $backlogCost = $this->manufacturer_backlog + $this->distributor_backlog + $this->wholesaler_backlog + $this->retailer_backlog;
        $backlogCost *= $this->game()->first()->backlog_fee;

        return $stockCost + $backlogCost;
    }
    public function cost(string $role)
    {
        $stockField = $role . '_stock';
        $backlogField = $role . '_backlog';

//        $stock = 0.0;
//        switch ($role) {
//            case 'manufacturor':
//                $stock = $round->manufacturor_stock;
//                break;
//            case:
//
//        }
        if (!isset($this->$stockField)) {
            throw new \Exception("Invalid role provided: $role $stockField");
        }
        if (!isset($this->$backlogField)) {
            throw new \Exception("Invalid role provided: $role");
        }

        $stockCost = $this->$stockField * $this->game()->first()->unit_fee;
        $backlogCost = $this->$backlogField * $this->game()->first()->backlog_fee;

        return $stockCost + $backlogCost;
    }
}

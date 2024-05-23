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
        'current_stock',
        'backlog',
        'customer_orders',
        'total_cost',
        'round_time' // Not used right now
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    protected $fillable = ['game_id', 'current_round', 'current_stock', 'ordered_stock', 'backlog', 'customer_orders', 'total_cost', 'round_time'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}

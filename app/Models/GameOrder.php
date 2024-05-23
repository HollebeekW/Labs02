<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'round_number',
        'order_amount'
    ];


    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}

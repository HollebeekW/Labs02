<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerOrder extends Model
{
    use HasFactory;

    protected $table = 'player_orders'; // Explicitly defining the table name

    protected $fillable = [
        'game_player_id',
        'current_round',
        'order_amount'
    ];

    public function gamePlayer()
    {
        return $this->belongsTo(GamePlayer::class, 'game_player_id');
    }

}

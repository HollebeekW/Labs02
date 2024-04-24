<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePlayer extends Model
{
    use HasFactory;

    protected $table = 'game_players'; // Explicitly defining the table name

    protected $fillable = ['player_id', 'game_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}

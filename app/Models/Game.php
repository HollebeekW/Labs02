<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'max_rounds', 'unit_fee', 'backlog_fee', 'delivery_time'];

    public function gamePlayers()
    {
        return $this->hasMany(GamePlayers::class);
    }
    public function gameOrders()
    {
        return $this->hasMany(GameOrder::class);
    }

    public function rounds() {
        return $this->hasMany(Round::class);
    }
}

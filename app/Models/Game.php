<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'maxround', 'unit-fee', 'backlog-fee', 'delivery-time'];

    public function gamePlayers()
    {
        return $this->hasMany(GamePlayers::class);
    }
    public function gameOrders()
    {
        return $this->hasMany(GameOrder::class);
    }
}

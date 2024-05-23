<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'game_owner_id',
        'slug',
        'current_round',
        'max_round',
        'unit_fee',
        'backlog_fee',
        'delivery_time'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function boot(){
        parent::boot();

        static::creating(function ($game) {
            // Ensure the slug is unique
            do {
                $slug = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (Game::where('slug', $slug)->exists());

            $game->slug = $slug;
        });
    }


    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function userOrders()
    {
        return $this->hasManyThrough(UserOrder::class, User::class);
    }
    public function gameOrders()
    {
        return $this->hasMany(GameOrder::class);
    }
    public function rounds()
    {
        return $this->hasMany(Round::class);
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'game_owner_id');
    }

    public function latestRound()
    {
        return $this->rounds()->where('current_round', $this->current_round)->first();
    }
    public function getRoundWithOffset(int $offset)
    {
        $targetRoundNumber = $this->current_round + $offset;
        return $this->rounds()->where('current_round', $targetRoundNumber)->first();
    }
    public function deliveredGameOrder()
    {
        $targetNumber = $this->current_round - $this->delivery_time;
        return $this->gameOrders()->where('round_number', $targetNumber)->first();
    }
}

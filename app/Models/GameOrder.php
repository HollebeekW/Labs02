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
        'manufacturer_order',
        'distributor_order',
        'wholesaler_order',
        'retailer_order',
        'customer_order',
    ];


    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}

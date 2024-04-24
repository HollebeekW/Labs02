<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('player_orders', function (Blueprint $table) {
            $table->id();
            //Foreign key to the game_players table id
            $table->foreignId('game_players_id')->constrained('game_players')->onDelete('cascade');
            //Current round of the game when created
            $table->integer('round_number');
            //Amount ordered by player
            $table->integer('order_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_orders');
    }
};

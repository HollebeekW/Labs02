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
        Schema::create('game_orders', function (Blueprint $table) {
            $table->id();
            //Foreign key to the games table id
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            //Current round of the game when created
            $table->integer('round-number');
            //Average of all player_orders this round
            $table->double('order_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_orders');
    }
};

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
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->integer('current_round');

            //nullable, for testing purposes. To be removed
            $table->integer('ordered_stock')->nullable();
            $table->integer('current_stock')->nullable();
            $table->integer('backlog')->nullable();
            $table->integer('customer_orders')->nullable();
            $table->double('total_cost')->nullable();
            $table->float('round_time')->nullable();

            //foreign key
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rounds');
    }
};

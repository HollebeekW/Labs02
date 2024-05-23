<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->bigInteger('game_owner_id')->unsigned()->nullable()->after('name');


            // Add foreign key constraint to game_owner_id referencing users(id)
            //$table->foreign('game_owner_id')->references('id')->on('users')->onDelete('set null');
        });

        // Set the game_owner_id to the first user for existing games
        $firstUser = DB::table('users')->first();
        if ($firstUser) {
            DB::table('games')->update(['game_owner_id' => $firstUser->id]);
        }

        Schema::table('games', function (Blueprint $table) {
            // Add foreign key constraint to game_owner_id referencing users(id)
            $table->foreign('game_owner_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['game_owner_id']);
            $table->dropColumn('game_owner_id');
        });
    }
};

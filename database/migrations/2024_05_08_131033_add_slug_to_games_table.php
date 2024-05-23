<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Game;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Adds a unique slug column with a length of 6 characters
        Schema::table('games', function (Blueprint $table) {
            $table->string('slug', 6)->unique()->after('name')->nullable(); // Temporary nullable
        });

        // Populate the slug for existing games
        $games = Game::all();
        foreach($games as $game) {
            do {
                $slug = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (Game::where('slug', $slug)->exists());

            $game->slug = $slug;
            $game->save();
        }

        Schema::table('games', function(Blueprint $table){
           $table->string('slug', 6)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('slug'); // Removes the slug column if the migration is rolled back
        });
    }

};

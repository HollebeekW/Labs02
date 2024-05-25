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
        Schema::table('game_orders', function (Blueprint $table) {
            $table->dropColumn('order_amount');
            $table->double('customer_order')->after('round_number');
            $table->double('retailer_order')->after('round_number');
            $table->double('wholesaler_order')->after('round_number');
            $table->double('distributor_order')->after('round_number');
            $table->double('manufacturer_order')->after('round_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_orders', function (Blueprint $table) {
            $table->double('order_amount');
            $table->dropColumn('customer_order');
            $table->dropColumn('retailer_order');
            $table->dropColumn('wholesaler_order');
            $table->dropColumn('distributor_order');
            $table->dropColumn('manufacturer_order');
        });
    }
};

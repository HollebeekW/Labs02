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
        Schema::table('rounds', function (Blueprint $table) {
            $table->double('distributor_send')->after('distributor_stock');
            $table->double('manufacturer_send')->after('manufacturer_stock');
            $table->double('wholesaler_send')->after('wholesaler_stock');
            $table->double('retailer_send')->after('retailer_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rounds', function (Blueprint $table) {
            $table->dropColumn('distributor_send');
            $table->dropColumn('manufacturer_send');
            $table->dropColumn('wholesaler_send');
            $table->dropColumn('retailer_send');
        });
    }
};

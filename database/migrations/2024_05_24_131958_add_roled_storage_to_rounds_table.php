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
            $table->dropColumn('current_stock');
            $table->dropColumn('backlog');


            $table->double('retailer_stock')->after('current_round');
            $table->double('retailer_backlog')->after('current_round');

            $table->double('wholesaler_stock')->after('current_round');
            $table->double('wholesaler_backlog')->after('current_round');

            $table->double('manufacturer_stock')->after('current_round');
            $table->double('manufacturer_backlog')->after('current_round');

            $table->double('distributor_stock')->after('current_round');
            $table->double('distributor_backlog')->after('current_round');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rounds', function (Blueprint $table) {
            $table->double('current_stock')->after('current_round');
            $table->double('backlog')->after('current_round');

            $table->dropColumn('retailer_stock');
            $table->dropColumn('retailer_backlog');

            $table->dropColumn('wholesaler_stock');
            $table->dropColumn('wholesaler_backlog');

            $table->dropColumn('manufacturer_stock');
            $table->dropColumn('manufacturer_backlog');

            $table->dropColumn('distributor_stock');
            $table->dropColumn('distributor_backlog');
        });
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTrackingOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracking_orders', function (Blueprint $table) {
            $table->renameColumn('status', 'new_status');
            $table->boolean('old_status')->default(0)->after('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracking_orders', function (Blueprint $table) {
            $table->renameColumn('new_status', 'status');
            $table->dropColumn('old_status');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeEventIdColumnNullableInDeliveryOrdersHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deliveryOrdersHistory', function (Blueprint $table) {
            $table->integer('eventId')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deliveryOrdersHistory', function (Blueprint $table) {
            $table->integer('eventId')->change();
        });
    }
}

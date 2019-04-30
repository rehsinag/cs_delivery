<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSicStatusColumnToDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deliveryOrders', function (Blueprint $table){
            $table->enum('sicStatus', ['N', 'A'])->after('springDocStatus')->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deliveryOrders', function (Blueprint $table){
            $table->dropColumn('sicStatus');
        });
    }
}

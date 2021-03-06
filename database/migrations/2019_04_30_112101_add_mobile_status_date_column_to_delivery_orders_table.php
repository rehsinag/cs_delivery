<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMobileStatusDateColumnToDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deliveryOrders', function (Blueprint $table){
            $table->date('statusDate')->after('deliveryDate')->nullable();
        });
        DB::unprepared('ALTER VIEW `deliveryOrdersProcessed` AS
        select * from `deliveryOrders` where `status` IN ("' . \App\Status::DELIVERED .'", "' . \App\Status::REJECT_PRODUCT .'", "' . \App\Status::REJECT_DELIVERY .'")
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deliveryOrders', function (Blueprint $table){
            $table->dropColumn('statusDate');
        });
        DB::unprepared('ALTER VIEW `deliveryOrdersProcessed` AS
        select * from `deliveryOrders` where `status` IN ("' . \App\Status::DELIVERED .'", "' . \App\Status::REJECT_PRODUCT .'", "' . \App\Status::REJECT_DELIVERY .'")
        ');
    }
}

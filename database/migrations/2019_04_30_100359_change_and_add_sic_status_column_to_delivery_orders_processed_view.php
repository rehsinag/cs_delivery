<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAndAddSicStatusColumnToDeliveryOrdersProcessedView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
        DB::unprepared('ALTER VIEW `deliveryOrdersProcessed` AS
        select * from `deliveryOrders` where `status` = "' . \App\Status::DELIVERED .'"
        ');
    }
}

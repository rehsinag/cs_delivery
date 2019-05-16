<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDeliveryOrdersProcessedView150520191 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('ALTER VIEW `deliveryOrdersProcessed` AS
        SELECT *, 
        (SELECT CONCAT(`firstName`, \' \', `lastName`, \' \', `middleName`) FROM `deliveryUsers` u WHERE u.id=deliveryUserId) As `cFIO`, 
        (SELECT `text` FROM `deliveryUsersComments` c WHERE c.requestId=`o`.requestId ORDER BY `created_at` DESC LIMIT 1) AS `cComment` 
        FROM `deliveryOrders` as `o` 
        WHERE `status` IN ("' . \App\Status::DELIVERED .'", "' . \App\Status::REJECT_PRODUCT .'", "' . \App\Status::REJECT_DELIVERY .'", "' . \App\Status::REJECT_VISUAL .'", "' . \App\Status::NOT_DIAL .'") 
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
        select * from `deliveryOrders` where `status` IN ("' . \App\Status::DELIVERED .'", "' . \App\Status::REJECT_PRODUCT .'", "' . \App\Status::REJECT_DELIVERY .'")
        ');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryOrders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('productId');
            $table->integer('deliveryUserId')->nullable();
            $table->integer('branchId');

            $table->string('firstName');
            $table->string('lastName');
            $table->string('middleName')->nullable();
            $table->string('iin');
            $table->string('phone');

            $table->integer('city');
            $table->integer('county');
            $table->string('region')->nullable();
            $table->string('street');
            $table->string('house');
            $table->string('apartment');

            $table->date('deliveryDate');
            $table->integer('status')->default(\App\Status::ACTIVE);
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveryOrders');
    }
}

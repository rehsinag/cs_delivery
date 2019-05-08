<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryUsersCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryUsersComments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requestId');
            $table->integer('deliveryUserId');
            $table->integer('status')->default(\App\Status::ACTIVE);
            $table->text('text')->nullable();
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
        Schema::dropIfExists('deliveryUsersComments');
    }
}

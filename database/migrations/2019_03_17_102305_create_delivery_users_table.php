<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryUsers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('companyId');
            $table->integer('branchId');
            $table->string('login');
            $table->string('password');
            $table->string('email');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('middleName');
            $table->text('description');
            $table->integer('role');
            $table->integer('loginAttemptsCount')->default(1);
            $table->integer('status')->default(\App\Status::ACTIVE);
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
        Schema::dropIfExists('deliveryUsers');
    }
}

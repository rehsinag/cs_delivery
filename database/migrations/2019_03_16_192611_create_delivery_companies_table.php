<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryCompanies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('displayName');
            $table->text('description');
            $table->text('address');
            $table->string('contacts');
            $table->string('context')->nullable();
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
        Schema::dropIfExists('deliveryCompanies');
    }
}

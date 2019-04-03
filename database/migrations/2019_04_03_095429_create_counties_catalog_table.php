<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountiesCatalogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countiesCatalog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('displayName');
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
        Schema::dropIfExists('countiesCatalog');        
    }
}

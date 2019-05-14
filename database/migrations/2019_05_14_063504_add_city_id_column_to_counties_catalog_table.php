<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityIdColumnToCountiesCatalogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countiesCatalog', function (Blueprint $table){
            $table->integer('cityId')->after('displayName')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countiesCatalog', function (Blueprint $table){
            $table->dropColumn('cityId');
        });
    }
}

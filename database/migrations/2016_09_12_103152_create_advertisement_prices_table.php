<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advertisement_setting_id')->unsigned()->nullable();
            $table->integer('min_days')->unsigned()->nullable();
            $table->integer('max_days')->unsigned()->nullable();
            $table->integer('price')->unsigned()->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
            $table->softDeletes();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('advertisement_prices');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('no_advertisement')->unsigned()->nullable();
            $table->integer('rotational_time_ad')->unsigned()->nullable();
            $table->enum('type', array('Main','Banner','Category','Mingle'))->nullable();
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
        Schema::drop('advertisement_settings');
    }
}

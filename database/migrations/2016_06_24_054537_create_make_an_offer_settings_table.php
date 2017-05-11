<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakeAnOfferSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('make_an_offer_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('time_to_retract_offer');
            $table->integer('admin_user_id')->unsigned();
            $table->enum('status', ['Active', 'Inactive']);
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('make_an_offer_settings');
    }

}

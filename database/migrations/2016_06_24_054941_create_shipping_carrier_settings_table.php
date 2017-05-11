<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingCarrierSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('shipping_carrier_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id')->unsigned();
            $table->enum('active_in_system', ['Yes', 'No']);
            $table->decimal('additional_profit_margin', 5, 2);
            $table->datetime('effective_from_date');
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
        Schema::drop('shipping_carrier_settings');
    }

}

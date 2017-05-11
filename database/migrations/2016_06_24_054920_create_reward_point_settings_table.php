<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardPointSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('reward_point_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('buyer_earns_reward_point_on_purchase_of_every', 7, 2);
            $table->decimal('reward_point_value', 7, 2);
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
        Schema::drop('reward_point_settings');
    }

}

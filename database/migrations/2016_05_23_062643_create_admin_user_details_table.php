<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_user_id')->unsigned();
            $table->string('address_line1','100');
            $table->string('address_line2','100');
            $table->integer('city_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->string('zipcode','20');
            $table->time('working_hours_from');
            $table->time('working_hours_to');
            $table->string('days_of_week','100');
            $table->decimal('deductibles', 5, 2);
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->integer('secret_question_id')->unsigned();
            $table->string('secret_answer','100');
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_user_details');
    }
}

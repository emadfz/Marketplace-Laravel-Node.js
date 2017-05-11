<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('promo_code')->nullable();            
            $table->decimal('discount', 8, 2)->unsigned()->nullable();
            $table->enum('discount_type', array('percentage','fix'))->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('selected_users')->nullable();
            $table->integer('users_id')->unsigned()->nullable();            
            $table->enum('user_type', array('Admin','Seller'))->nullable();
            $table->enum('status', array('Active','Inactive'))->nullable();
            $table->softDeletes();
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
        Schema::drop('users');
    }
}

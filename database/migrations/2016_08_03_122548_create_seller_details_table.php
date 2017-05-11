<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('business_name', 50);
            $table->integer('industry_type_id')->unsigned()->index();
            $table->foreign('industry_type_id')->references('id')->on('industry_types')->onDelete('restrict');
            
            $table->string('business_details', 500);
            
            $table->string('tax_id_number', 50);
            $table->string('business_reg_number', 50);
            $table->string('business_phone_number', 20);
            $table->string('website', 100);
            $table->integer('position_id')->unsigned()->index();
            $table->string('position_other', 20);
            $table->string('video_link', 255)->nullable();
            
            $table->string('bank_name', 100)->nullable();
            $table->string('bank_phone_number', 20)->nullable();
            $table->string('bank_routing_number', 25)->nullable();
            $table->string('bank_account_number', 25)->nullable();
            
            $table->timestamps();
            //$table->timestamp('updated_at');
            //$table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('seller_details');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('offer_master_id')->unsigned()->nullable();
            $table->enum('user_type',['buyer','seller'])->nullable();
            $table->integer('offer_quantity')->nullable();
            $table->string('note')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
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
        Schema::drop('offer_detail');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaymentCardDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_payment_card_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->text('token'); //From payment gateway service provider

            $table->string('full_name', 100);
            $table->enum('card_type', ['Master', 'Visa']);
            $table->string('card_number', 25);
            $table->string('expiry_month', 10);
            $table->string('expiry_year', 4);//YEAR

            $table->softDeletes(); //deleted_at
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
    public function down() {
        Schema::drop('user_payment_card_details');
    }

}

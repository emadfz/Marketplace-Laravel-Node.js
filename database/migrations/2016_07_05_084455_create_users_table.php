<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('user_type', ['Buyer', 'Individual Seller', 'Business Seller']);
            $table->string('username', 25)->unique()->index();
            $table->string('email', 100)->unique()->index();
            $table->string('password', 100);
            $table->string('image', 255)->nullable();
            $table->enum('title', ['Mr', 'Mrs', 'Miss'])->nullable();
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Prefer not to say']);
            $table->string('phone_number', 20);
            $table->boolean('is_email_verified')->default(0);
            $table->string('activation_code', 50);
            $table->boolean('is_phone_verified')->default(0);
            $table->boolean('is_mingle_sync')->default(0);
            $table->string('facebook_id', 100)->nullable();
            $table->string('google_id', 100)->nullable();
            $table->string('twitter_id', 100)->nullable();
            $table->string('linkedin_id', 100)->nullable();
            $table->boolean('is_subscribed')->default(0)->comment = "Subscribed for newsletter";
            $table->integer('secret_question_id')->unsigned()->index();
            $table->string('secret_answer', 100);
            $table->enum('status', ['Active', 'Inactive', 'Pending', 'Blocked', 'Verified'])->default('Pending')->index(); //Verified is for seller only,admin will verify business seller from admin
            $table->dateTime('activation_datetime')->nullable();
            $table->dateTime('seller_verified_datetime')->nullable()->comment = "It will be used when admin verify the seller";
            $table->rememberToken();
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
        Schema::drop('users');
    }

}

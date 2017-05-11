<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginHistoryUsersTable extends Migration {

    /**
     * Run the migrations. | Its for front side users
     *
     * @return void
     */
    public function up() {
        Schema::create('login_history_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->nullable()->index();
            $table->string('email', 100)->index();
            $table->tinyInteger('attempts');
            $table->enum('status', ['success', 'fail']);
            $table->enum('login_from', ['Web', 'Facebook', 'Google', 'Twitter', 'Linkedin', 'Api'])->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            // initiated_from web,facebook,google,linkedin,twitter
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('login_history_users');
    }

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecretQuestionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('secret_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('secret_question', 255);
            $table->integer('admin_user_id')->unsigned();
            $table->enum('status', ['Active', 'Inactive']);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('secret_questions');
    }

}

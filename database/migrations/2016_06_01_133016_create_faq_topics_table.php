<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqTopicsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('faq_topics', function($table) {
            $table->increments('id');
            $table->integer('admin_user_id')->unsigned();
            $table->string('topic_name');
            $table->string('slug');
            $table->timestamps();
            //$table->smallInteger('order');
            //$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('faq_topics');
    }

}

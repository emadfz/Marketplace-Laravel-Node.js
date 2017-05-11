<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function($table) {
            $table->increments('id');
            $table->integer('faq_topic_id')->unsigned()->index();
            $table->string('question');
            $table->text('answer');
            $table->timestamps();
            $table->foreign('faq_topic_id')->references('id')->on('faq_topics')->onDelete('cascade');
            //$table->smallInteger('order');
            //$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('faqs');
    }
}

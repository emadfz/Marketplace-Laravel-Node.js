<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermAndConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('term_and_conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('topic_name', 255);
            $table->string('slug', 255);
            $table->text('terms_conditions');
            $table->string('meta_title', 50);
            $table->string('meta_keywords', 200);
            $table->string('meta_description', 150);
            $table->enum('status', ['Published','Draft'])->index();
            $table->integer('admin_user_id')->unsigned();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('term_and_conditions');
    }
}

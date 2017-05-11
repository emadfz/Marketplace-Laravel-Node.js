<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportAbusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_abuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ref_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->enum('type',array('topic', 'comment'));
            $table->string('report_value','255')->nullable();
            $table->string('something_else','255')->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forum_likes');
    }
}

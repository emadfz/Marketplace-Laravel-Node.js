<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TopicDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('department_name','100');
            $table->string('department_description','100');
            $table->string('color','100');
            $table->integer('topics')->nullable()->default(0)->index();
            $table->softDeletes();
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topic_departments');
    }
}

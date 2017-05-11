<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('topic_name','100');
            $table->text('topic_description','100');
            $table->integer('topic_department_id')->nullable()->index();
            $table->integer('admin_users_id')->nullable()->default(0)->index();
            $table->integer('total_likes')->nullable()->default(0)->index();
            $table->integer('total_dislikes')->nullable()->default(0)->index();
            $table->integer('total_comments')->nullable()->default(0)->index();
            $table->integer('total_views')->nullable()->default(0)->index();
            $table->tinyInteger('is_deleted');
            $table->enum('status', array('Active','Inactive'));
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
        Schema::drop('forums');
    }
}

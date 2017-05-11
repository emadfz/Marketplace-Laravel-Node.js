<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forum_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->longText('comment');
            $table->integer('total_likes')->nullable()->default(0)->index();
            $table->integer('total_dislikes')->nullable()->default(0)->index();
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
        Schema::drop('forum_comments');
    }
}

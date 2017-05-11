<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_title','100');
            $table->string('slug','100');
            $table->text('description');
            $table->string('meta_title', 50);
            $table->string('meta_keywords', 200);
            $table->string('meta_description', 150);
            $table->enum('status', ['Published','Draft'])->index();
            
            // {"header" : { "front_menu_id" :1, "front_page_id" :2  },  "footer" : { "front_menu_id" :2, "front_page_id" :3  }}
            $table->integer('header_front_menu_id')->unsigned()->index();
            $table->integer('header_front_page_id')->unsigned()->index();
            $table->integer('footer_front_menu_id')->unsigned()->index();
            $table->integer('footer_front_page_id')->unsigned()->index();
            
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
        Schema::drop('content_pages');
    }
}

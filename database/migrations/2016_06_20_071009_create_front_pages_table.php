<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_name','50');
            $table->string('page_relative_path','200');
            $table->integer('front_menu_id')->unsigned()->index();
            $table->foreign('front_menu_id')->references('id')->on('front_menus');
            $table->tinyInteger('status')->unsigned();
            $table->tinyInteger('priority_order');
            $table->enum('position',array('Header', 'Footer'))->index();
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
        Schema::drop('front_pages');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('menu_name','50');
            $table->string('menu_description','500');
            $table->tinyInteger('priority_order');
            $table->enum('is_visible',array('Y', 'N'))->index();
            $table->enum('position',array('Header', 'Footer', 'Both'))->index();
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
        Schema::drop('front_menus');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttributeSetCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_set_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_set_id')->nullable()->index();            
            $table->integer('attribute_set_categoryid')->nullable()->index();           
            $table->tinyInteger('is_deleted');
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
        Schema::drop('attribute_set_categories');
    }
}

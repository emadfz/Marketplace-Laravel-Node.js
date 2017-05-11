<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attribute_name','100');
            $table->string('attribute_description','500');
            $table->integer('attribute_set_id')->nullable()->index();     
            $table->tinyInteger('variation_allowed');
            $table->tinyInteger('view_in_filter');
            $table->tinyInteger('comparable');
            $table->string('catelog_input_type','10');
            $table->tinyInteger('is_visible');
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
        Schema::drop('attributes');
    }
}

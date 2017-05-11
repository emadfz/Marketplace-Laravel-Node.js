<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductskuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productsku', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku','100');
            $table->integer('p_id')->unsigned();
            $table->decimal('qty', 5, 2);
            $table->decimal('price', 5, 2);
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
        Schema::drop('productsku');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsOldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_old_', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_title','100');
            $table->string('product_description','500');
            $table->enum('listing_status', array('draft'));
            $table->string('manufacturer','100');
            $table->integer('producttype_id')->unsigned();;
            $table->integer('codetype_id')->unsigned();;
            $table->string('code_value','100');
            $table->tinyInteger('is_bulk');
            $table->decimal('total_stock',5, 2);
            $table->decimal('unit_price', 5, 2);
            $table->decimal('normal_price', 5, 2);
            $table->enum('selling_mode', array('MakeAnOffer','Auction'));
            $table->enum('condition', array('New','Used','Refurbished'));
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
        Schema::drop('products_old_');
    }
}

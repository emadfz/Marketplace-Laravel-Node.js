<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulkProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seller_id');
            $table->integer('product_id');
            $table->integer('product_sku_id');
            $table->string('type_of_packaging')->nullable();
            $table->string('no_of_individual_items_in_a_packaging')->nullable();
            $table->string('packaging_units_available_in_stocks')->nullable();
            $table->string('bulk_quantity')->nullable();
            $table->string('price')->nullable();
            $table->string('amount_saved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
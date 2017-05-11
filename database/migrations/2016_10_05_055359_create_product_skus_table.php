<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSkusTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('product_skus', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('product_id')->unsigned()->index();
            //$table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');

            $table->decimal('additional_price', 10, 2)->default(0);
            $table->decimal('final_price', 10, 2)->default(0)->comment = "Summation of product base_price and sku additional_price";
            $table->string('sku', 50);
            $table->integer('quantity');
            $table->enum('available_in_bulk', ['Yes', 'No'])->default('No');
            $table->string('image', 100)->nullable();
            $table->enum('is_default', ['Yes', 'No'])->default('No')->comment = "Set only one sku as default per product id";
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('product_skus');
    }

}

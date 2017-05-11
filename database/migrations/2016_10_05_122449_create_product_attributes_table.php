<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('product_id')->unsigned()->index();
            //$table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');

            $table->bigInteger('product_sku_id')->unsigned()->index();
            //$table->foreign('product_sku_id')->references('id')->on('product_skus')->onDelete('restrict');

            $table->integer('attribute_id')->unsigned()->index();
            //$table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('restrict');

            $table->integer('attribute_value_id')->nullable()->unsigned()->index();
            //$table->foreign('attribute_value_id')->references('id')->on('attribute_values')->onDelete('restrict');

            $table->integer('attribute_set_id')->nullable()->unsigned()->index();
            //$table->foreign('attribute_set_id')->references('id')->on('attribute_sets')->onDelete('restrict');

            $table->string('attribute_value', 512)->nullable()->comment = "attribute value for non variant attribute";

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('product_attributes');
    }

}

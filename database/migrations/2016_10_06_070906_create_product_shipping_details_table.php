<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductShippingDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('product_shipping_details', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('product_id')->unsigned()->index();
            //$table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');

            $table->decimal('parcel_dimension_length', 5, 2)->default(0);
            $table->decimal('parcel_dimension_width', 5, 2)->default(0);
            $table->decimal('parcel_dimension_height', 5, 2)->default(0);
            $table->enum('length_class', ['cm', 'mm', 'in']);
            $table->decimal('parcel_weight', 5, 2)->default(0);
            $table->enum('weight_class', ['kg', 'gm', 'lb']);
            $table->enum('shipping_type', ['Marketplace', 'Seller']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('product_shipping_details');
    }

}

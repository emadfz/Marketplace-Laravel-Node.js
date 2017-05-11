<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAuctionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('product_auctions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('product_id')->unsigned()->index();
           // $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');

            $table->enum('mode', ['By price', 'By time']);
            $table->decimal('min_bid_increment', 10, 2)->default(0);
            $table->decimal('min_reserved_price', 10, 2)->default(0);
            $table->decimal('max_product_price', 10, 2)->default(0);
            $table->timestamp('start_datetime')->nullable();
            $table->timestamp('end_datetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('product_auctions');
    }

}

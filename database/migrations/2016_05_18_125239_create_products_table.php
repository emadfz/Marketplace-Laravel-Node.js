<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
//        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('category_id')->unsigned()->index();
            //$table->foreign('category_id')->references('id')->on('category')->onDelete('restrict');

            $table->integer('user_id')->unsigned()->index()->comment = "Its for user type Seller";
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->string('system_generated_product_id', 20)->nullable();

            $table->string('name', 100);
            $table->string('product_slug', 100)->nullable();
            $table->string('sku_prefix', 30)->nullable();
            $table->text('description');
            $table->string('manufacturer', 100);
            $table->enum('status', ['Active', 'Inactive', 'Draft', 'Blocked'])->default('Draft');

            $table->decimal('product_listing_price', 10, 2)->default(0)->comment = "Product listing price";
            $table->enum('mode_of_selling', ['Buy it now', 'Make an offer', 'Auction', 'Buy it now and Make an offer', 'Buy it now and Auction']);
            $table->decimal('base_price', 10, 2)->default(0)->comment = "mos - Buy it now";
            $table->integer('max_order_quantity')->default(0)->comment = "mos - Buy it now";
            $table->decimal('min_reserved_price', 10, 2)->default(0)->comment = "mos - Make an offer";
            $table->decimal('max_product_price', 10, 2)->default(0)->comment = "mos - Make an offer";
            $table->integer('auction_id')->unsigned()->index()->comment = "mos - Auction";

            $table->enum('warranty_applicable', ['Yes', 'No'])->default('No');
            $table->enum('warranty_type', ['Seller', 'Manufacturer'])->nullable();
            $table->tinyInteger('warranty_duration')->nullable();
            $table->enum('warranty_duration_type', ['Days', 'Months', 'Years'])->nullable();

            $table->enum('return_applicable', ['Yes', 'No'])->default('No');
            $table->tinyInteger('return_acceptance_days');

            $table->integer('user_address_id')->unsigned()->index();
           // $table->foreign('user_address_id')->references('id')->on('user_addresses')->onDelete('restrict');

            $table->enum('product_type', ['Simple', 'Combo', 'Configurable'])->nullable();

            $table->string('model', 50)->nullable()->comment = "Product model";

            $table->integer('product_condition_id')->unsigned()->index()->nullable();
          //  $table->foreign('product_condition_id')->references('id')->on('product_conditions')->onDelete('restrict');

            $table->integer('occassion_id')->unsigned()->index()->nullable();
            //$table->foreign('occassion_id')->references('id')->on('occassions')->onDelete('restrict');

            $table->string('video_url', 200)->nullable();
            $table->string('video_filename', 100)->nullable();

            $table->string('meta_title', 50)->nullable();
            $table->string('meta_keywords', 200)->nullable();
            $table->string('meta_description', 150)->nullable();

            $table->enum('variation_allowed', ['Yes', 'No'])->default('No');
            $table->enum('promotion_applicable', ['Yes', 'No'])->default('No');
            $table->string('related_product_ids', 150)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
        
//        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('products');
    }

}

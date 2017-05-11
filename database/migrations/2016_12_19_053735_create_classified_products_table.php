<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassifiedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classified_products', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('system_generated_product_id');
            $table->integer('user_id');
            $table->integer('user_address_id');
            $table->integer('category_id');
            $table->integer('product_conditions_id');
            $table->string('name');
            $table->string('video_link');
            $table->longText('description');
            $table->enum('product_origin', ['Yes', 'No']);
            $table->string('meta_tag');
            $table->string('meta_keyword');
            $table->longText('meta_description');
            $table->string('product_slug');
            $table->enum('status', ['Active', 'Inactive','Draft','Blocked']);
            $table->decimal('product_listing_price',10,2);
            $table->decimal('base_price',10,2);
            $table->timestamps();
            $table->softDeletes();
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
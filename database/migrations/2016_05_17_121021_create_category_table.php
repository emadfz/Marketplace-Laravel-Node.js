<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('category', function(Blueprint $table) {
            $table->increments('id');
            $table->string('text')->nullable();
            $table->text('description')->nullable();
            $table->string('category_slug')->nullable();
            $table->integer('parent_id')->unsigned()->nullable()->index();
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->nullable();
            $table->integer('lft')->unsigned()->nullable()->index();
            $table->integer('rgt')->unsigned()->nullable()->index();
            $table->integer('depth')->unsigned()->nullable();
            $table->enum('scope', ['Products', 'Services'])->default('Products')->nullable();
            $table->enum('type', ['General', 'Special'])->default('General')->nullable();
            $table->integer('product_conditions_id')->unsigned()->nullable();
            $table->decimal('commission', 10, 2)->default(0)->comment = "Used for scope field - Products";
            $table->decimal('buy_it_now_fees', 10, 2)->default(0)->comment = "Used for scope field - Products";
            $table->decimal('make_an_offer_fees', 10, 2)->default(0)->comment = "Used for scope field - Products";
            $table->decimal('auction_fees', 10, 2)->default(0)->comment = "Used for scope field - Products";
            $table->decimal('set_preview_fees', 10, 2)->default(0)->comment = "Used for scope field - Products";
            $table->decimal('seller_preview_charges', 10, 2)->default(0)->comment = "Used for scope field - Products";
            $table->decimal('buyer_preview_charges', 10, 2)->default(0)->comment = "Used for scope field - Products";
            $table->decimal('listing_fees', 10, 2)->default(0)->comment = "Used for scope field - Services";
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('category');
    }

}

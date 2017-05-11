<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditOccasionIdToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('products', function ($table) {
            $table->string('occassion_id')->nullable()->change();
        });*/
        DB::query("ALTER TABLE `products` CHANGE COLUMN `occassion_id` `occassion_id` varchar(255) NULL;");
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
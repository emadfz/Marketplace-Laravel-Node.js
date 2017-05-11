<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestPreviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_preview', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('classified_products_id');
            $table->date('preview_date');
            $table->string('preview_from_time',50);
            $table->string('preview_to_time',50);
            $table->enum('status',['Pending','Cancel','Done'])->default('Pending');
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

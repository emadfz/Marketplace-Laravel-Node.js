<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndustryTypesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('industry_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->softDeletes();//deleted_at
            $table->timestamps();
            //$table->timestamp('updated_at');
            //$table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('industry_types');
    }

}

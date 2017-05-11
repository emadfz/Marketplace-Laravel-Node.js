<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplateFieldsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('email_template_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('email_template_id')->unsigned()->index();
            $table->foreign('email_template_id')->references('id')->on('email_templates')->onDelete('cascade');
            $table->string('field_name', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('email_template_fields');
    }

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewslettersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('newsletter_title', '100');
            $table->text('newsletter_content');
            $table->enum('status', ['Draft', 'Active', 'Sent']);
            $table->integer('admin_user_id')->unsigned();
            $table->date('newsletter_date');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('newsletters');
    }

}

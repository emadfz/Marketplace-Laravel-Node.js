<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplatesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template_key', 255)->unique()->index();
            $table->string('template_title', 255);
            $table->string('email_subject', 255);
            $table->text('email_content');
            $table->string('notification_content', 512);
            $table->string('sms_content', 512);
            $table->integer('admin_user_id')->unsigned()->index()->default(1);
            $table->softDeletes(); //deleted_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('email_templates');
    }

}

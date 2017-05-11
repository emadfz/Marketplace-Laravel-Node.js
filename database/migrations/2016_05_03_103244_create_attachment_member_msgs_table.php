<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentMemberMsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_member_msgs', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('sender_member_msgs_id')->unsigned();
            $table->string('relativepath_attachment','200');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attachment_member_msgs');
    }
}

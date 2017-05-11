<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentOtherUserMsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_otherUser_msgs', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('sender_otherUser_msgs_id')->unsigned();
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
        Schema::drop('attachment_otherUser_msgs');
    }
}

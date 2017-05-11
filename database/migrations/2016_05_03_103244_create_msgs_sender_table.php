<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsgsSenderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msgs_sender', function (Blueprint $table) {
        
            $table->increments('id');
            $table->integer('messages_id')->unsigned();
            
            $table->integer('sender_employee_msgs_id')->unsigned()->nullable();
            $table->integer('sender_member_msgs_id')->unsigned()->nullable();
            $table->integer('sender_otheruser_msgs_id')->unsigned()->nullable();
            
            $table->integer('msg_fromid')->unsigned();
            $table->tinyInteger('msg_sender_issuperadmin')->nullable();
            $table->enum('msg_status',array('new', 'draft','deleted'));
            $table->tinyInteger('msg_isRead')->nullable();
            $table->tinyInteger('msg_isFlagged')->nullable();
            $table->tinyInteger('msg_isDeleted_by_sender')->nullable();
            $table->string('msg_type','10')->nullable();
            $table->tinyInteger('msg_isMovedto_folder')->nullable();
            $table->tinyInteger('msg_IsReply')->nullable();
            $table->integer('msg_replyto_messageid')->unsigned()->nullable();
            $table->tinyInteger('msg_IsNotified')->nullable();
            
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
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
        Schema::drop('sender_employee_msgs');
    }
}

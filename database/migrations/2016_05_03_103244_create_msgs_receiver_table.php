<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsgsReceiverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msgs_receiver', function (Blueprint $table) {
            $table->increments('id');            

            $table->integer('messages_id')->unsigned();
            
            $table->integer('msgs_sender_id')->unsigned();            
            
            $table->integer('receiver_employee_msgs_id')->unsigned()->nullable();
            $table->integer('receiver_member_msgs_id')->unsigned()->nullable();
            $table->integer('receiver_otheruser_msgs_id')->unsigned()->nullable();
            
            $table->string('receiver_email','100')->nullable();       
                                                            
            $table->tinyInteger('msg_isMovedto_folder')->nullable();
            $table->integer('msg_folder_id')->unsigned()->nullable();
            
            $table->tinyInteger('msg_isNotified')->nullable();
            $table->tinyInteger('msg_isRead')->nullable();
            $table->tinyInteger('msg_isFlagged')->nullable();
                                    
            $table->string('msg_type','10')->nullable();            
            $table->enum('msg_status',array('new', 'draft','deleted'));
            
            $table->tinyInteger('msg_isDeletedby_receiver')->nullable();
                      
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
        Schema::drop('receiver_msgs');
    }
}

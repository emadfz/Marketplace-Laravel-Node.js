<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiverEmployeeMsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiver_employee_msgs', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('sender_employee_msgs_id')->unsigned();
            $table->string('emp_professional_email_id','100');            
            
            $table->integer('msg_sentTo_id')->unsigned();
                                    
            $table->tinyInteger('msg_isMovedto_folder');                        
            $table->integer('msg_folder_id')->unsigned();                        
            
            $table->tinyInteger('msg_IsNotified');
            $table->tinyInteger('msg_isRead');
            $table->tinyInteger('msg_isFlagged');
                        
            $table->string('msg_type','10');            
            $table->enum('msg_status',array('new', 'draft','deleted'));
            
            $table->tinyInteger('msg_isDeletedby_receiver');
                      
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
        Schema::drop('receiver_employee_msgs');
    }
}

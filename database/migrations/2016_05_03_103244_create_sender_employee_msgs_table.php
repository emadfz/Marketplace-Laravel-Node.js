<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSenderEmployeeMsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sender_employee_msgs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('msg_subject','500');
            $table->text('msg_content');
            $table->integer('msg_fromid')->unsigned();
            $table->tinyInteger('msg_sender_issuperadmin');
            $table->enum('msg_status',array('new', 'draft','deleted'));
            $table->tinyInteger('msg_isRead');
            $table->tinyInteger('msg_isFlagged');
            $table->tinyInteger('msg_isDeleted_by_sender');            
            $table->string('msg_type','10');            
            $table->tinyInteger('msg_isMovedto_folder');                        
            $table->tinyInteger('msg_IsReply');       
            $table->integer('msg_replyto_messageid')->unsigned();                             
            $table->tinyInteger('msg_IsNotified');
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

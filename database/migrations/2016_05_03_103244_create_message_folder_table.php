<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageFolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_folders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('folder_name','100')->nullable();
            
            $table->integer('receiver_employee_msgs_id')->unsigned()->nullable();
            $table->integer('receiver_member_msgs_id')->unsigned()->nullable();
            $table->integer('receiver_otheruser_msgs_id')->unsigned()->nullable();            
                                    
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
        Schema::drop('message_folders');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('path')->nullable();
            $table->integer('imageable_id')->unsigned()->nullable();            
            $table->string('imageable_type')->nullable();
            $table->string('file_type')->nullable();            
            $table->timestamp('created_at');
            $table->timestamp('updated_at');                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('files');
    }
}

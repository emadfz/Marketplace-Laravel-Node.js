<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_user_id')->nullable()->index();
            $table->integer('module_id')->nullable()->index();
            $table->tinyInteger('read_access');
            $table->tinyInteger('create_access');
            $table->tinyInteger('update_access');
            $table->tinyInteger('delete_access');
            $table->tinyInteger('status');
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employee_modules');
    }
}
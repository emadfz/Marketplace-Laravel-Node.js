<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_code','50')->nullable();
            $table->string('first_name','50')->nullable();
            $table->string('last_name','50')->nullable();
            $table->enum('gender', array('Male','Female'))->nullable();
            $table->integer('designation')->unsigned()->nullable();
            $table->string('personal_email','100')->nullable();
            $table->string('professional_email','100')->nullable();
            $table->string('contact_number','20')->nullable();
            $table->date('dob')->nullable();
            $table->string('password','100')->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->string('photo_relative_path','100')->nullable();
            $table->integer('role_id')->unsigned()->nullable();
            $table->string('type_of_hire','20')->nullable();
            $table->string('service_location','20')->nullable();
            $table->decimal('wages', 5, 2)->nullable();
            $table->date('date_of_hire')->nullable();
            $table->string('status','20')->nullable();
            $table->rememberToken()->nullable();
            $table->boolean('confirmed')->default(0)->nullable();
            $table->string('confirmation_code')->nullable();
                        
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
        Schema::drop('admin_users');
    }
}

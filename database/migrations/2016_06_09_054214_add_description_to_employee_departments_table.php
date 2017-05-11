<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionToEmployeeDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_departments', function (Blueprint $table) {
            $table->string('department_description','100');
            $table->integer('topics')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_departments', function (Blueprint $table) {
             $table->dropColumn('department_description');
             $table->dropColumn('topics');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vendor_name', '50');
            $table->string('contact_person', '50');
            $table->string('contact_number', '20');
            $table->string('contact_email', '100');
            $table->string('address_line1', '100');
            $table->string('address_line2', '100');
            $table->string('zipcode', '20');
            $table->integer('country_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->string('account_number', '20')->nullable();
            $table->enum('vendor_type', ['Logistics', 'PaymentSystem', 'ITServices', 'Taxes', 'Legal', 'Accounting', 'Marketing']);
            $table->integer('admin_user_id')->unsigned();
            $table->enum('status', ['Active', 'Inactive']);
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('vendors');
    }

}

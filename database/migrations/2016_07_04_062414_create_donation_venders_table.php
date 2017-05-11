<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationVendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vendor_name','100');
            $table->string('vendor_description','100');
            $table->string('website_link','100');
            $table->decimal('admin_fees',5, 2);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', array('Active','Inactive'));
            $table->softDeletes();
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
        Schema::drop('donation_vendors');
    }
}

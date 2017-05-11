<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class Vendor_typesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $vendorType = ['Logistics', 'Payment Systems', 'IT Services', 'Taxes', 'Legal', 'Accounting', 'Marketing'];
        foreach ($vendorType AS $vendor) {
            DB::table('vendor_types')->insert([
                'vendor_type_name' => $vendor,
                'vendor_type_description' => '',
                'created_at' => Carbon::now(),
            ]);
        }
    }

}

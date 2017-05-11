<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VendorsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $vendorType = ['USPS', 'DHL', 'FedEx'];
        foreach ($vendorType AS $vendor) {
            DB::table('vendors')->insert([
                'vendor_name' => $vendor,
                'vendor_type' => 'Logistics',
                'status' => 'Active',
                'admin_user_id' => 1,
                'created_at' => Carbon::now()
            ]);
        }
    }

}

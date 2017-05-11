<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FrontMenusSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // front menus

        $check = DB::table('front_menus')->get();

        if (empty($check)) {

            DB::table('front_menus')->insert([
                'menu_name' => 'Buy',
                'menu_description' => 'Buy menu',
                'priority_order' => 1,
                'is_visible' => 'Y',
                'position' => 'Header',
                'created_at' => Carbon::now()
            ]);

            DB::table('front_menus')->insert([
                'menu_name' => 'Sell',
                'menu_description' => 'Sell menu',
                'priority_order' => 2,
                'is_visible' => 'Y',
                'position' => 'Both',
                'created_at' => Carbon::now()
            ]);

            DB::table('front_menus')->insert([
                'menu_name' => 'Help',
                'menu_description' => 'Help menu',
                'priority_order' => 3,
                'is_visible' => 'Y',
                'position' => 'Footer',
                'created_at' => Carbon::now()
            ]);

            // front pages
            DB::table('front_pages')->insert([
                'page_name' => 'About Us',
                'page_relative_path' => 'about-us',
                'front_menu_id' => 1,
                'status' => 1,
                'priority_order' => 1,
                'position' => 'Header',
                'created_at' => Carbon::now()
            ]);
        }
    }

}

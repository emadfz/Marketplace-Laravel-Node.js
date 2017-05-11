<?php

use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();
        
        DB::table('category')->insert([            
            'text' => 'Root category',                        
            'status' => 'Active',
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);        
        
        App\Models\Category::where('text', 'Root category')->update(['id' => 0]);
        
    }
}

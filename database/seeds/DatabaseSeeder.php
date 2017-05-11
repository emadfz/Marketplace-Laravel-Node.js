<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        //$this->call('DemoCategoriesTableSeeder');
        //$this->call('DemoProductsTableSeeder');

        // $this->call(UsersTableSeeder::class);
        
        DB::table('admin_users')->insert([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'professional_email' => 'sa@devanche.com',
            'personal_email' => 'sa@gmail.com',
            'password' => Hash::make('admin@123') ,
            'gender' => 'Male',
            'dob' => '1985-01-01',
            'role_id' => 1,
            'department_id' => 1,
            'status' => 'Active',
            'confirmed' => 1,
            'created_at' => '2016-05-24 15:40:38'
        ]);
        
        
        
        /*DB::table('admins')->insert([
            'name' => 'SuperAdmin',
            'email' => 'sa@gmail.com',
            'password' => bcrypt('admin123') ,
        ]);*/
        $this->call('PromotionsTableSeeder');
        $this->call('AdminUsersTableSeeder');
    }
    

}
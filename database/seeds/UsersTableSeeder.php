<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $faker = Faker\Factory::create();

        $limit = 500;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('users')->insert([ //,
                'first_name' => $faker->name,
                'last_name' => $faker->name,
                'username' => $faker->userName,
                'email' => $faker->unique()->email,
                'phone_number' => $faker->phoneNumber,
                'user_type' => array_rand(['Buyer','Individual Seller','Business Seller']),
                'status' => array_rand(['Blocked','Pending','Verified']),
                'created_at' => getCurrentDatetime(),
                'updated_at' => getCurrentDatetime(),
            ]);
        }
    }

}

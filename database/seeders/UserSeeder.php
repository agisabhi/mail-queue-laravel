<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $role = ['customer', 'user'];

        foreach (range(1, 100) as $value) {
            $random_index = array_rand($role);
            $data = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt("password"),
                'role' => $role[$random_index],
            ];
            User::create($data);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Lấy tất cả các giá trị rule_id hiện có từ bảng rules
        $ruleIds = DB::table('rules')->pluck('id')->toArray();

        $numberOfUsers = 15;

        for ($i = 0; $i < $numberOfUsers; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'avatar' => $faker->imageUrl(100, 100, 'people', true, 'Faker'),
                'phone' => $faker->phoneNumber,
                'gender' => $faker->randomElement(['male', 'female']),
                'birth_date' => $faker->date(),
                'rule_id' => $faker->randomElement($ruleIds), // Chọn rule_id hợp lệ
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => $faker->regexify('[A-Za-z0-9]{10}'),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]);
        }
    }

}

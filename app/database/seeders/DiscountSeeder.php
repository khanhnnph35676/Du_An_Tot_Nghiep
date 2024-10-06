<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {

            $startDate = fake()->dateTimeBetween('-1 month', '+1 month'); // Random start date
            $endDate = fake()->dateTimeBetween($startDate, '+1 month'); // Random end date after start date

            DB::table('discounts')->insert([
                'product_id' => "1",
                'discount' => fake()->numberBetween(1, 100),
                'priority' => fake()->numberBetween(1, 4),
                'start_date' => $startDate,
                'end_date' => $endDate
            ]);
        }
    }

}

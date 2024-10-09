<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleSeeder extends Seeder
{
    public function run()
    {
        DB::table('rules')->insert([
            ['rule_name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['rule_name' => 'User', 'created_at' => now(), 'updated_at' => now()],
            ['rule_name' => 'Core', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

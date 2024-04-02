<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'slug' => 'gratis',
            'price' => 0, //99.99
            'duration_in_months' => 3,
        ]);

        Plan::create([
            'slug' => 'mensual',
            'price' => 999, //12.00
            'duration_in_months' => 1,
        ]);

        Plan::create([
            'slug' => 'semestral',
            'price' => 5399, //12.00
            'duration_in_months' => 6,
        ]);

        Plan::create([
            'slug' => 'anual',
            'price' => 8999, //99.99
            'duration_in_months' => 12,
        ]);
    }
}

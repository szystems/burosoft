<?php

namespace Database\Seeders;

use App\Models\Rubro;
use Illuminate\Database\Seeder;
use Database\Factories\RubrosFactory;

class RubrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rubro::factory()->count(20)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Movimiento;
use Illuminate\Database\Seeder;

class MovimientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movimiento::factory()->count(100)->create();
    }
}

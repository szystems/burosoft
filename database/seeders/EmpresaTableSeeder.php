<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Empresa::create([
            'nombre' => 'Buro',
            'email' => 'eventos.buro@hotmail.com',
            'celular' => '59893119',
            'estado' => 1,
            'fecha_vencimiento' => '2050-12-31',

        ]);

        Empresa::factory()->count(20)->create();
    }
}

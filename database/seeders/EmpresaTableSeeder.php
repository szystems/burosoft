<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Config;
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
        // Crear una empresa específica
        $empresa = Empresa::create([
            'nombre' => 'Buro',
            'email' => 'eventos.buro@hotmail.com',
            'celular' => '59893119',
            'estado' => 1,
            'fecha_vencimiento' => '2050-12-31',
        ]);

        // Crear una configuración asociada a la empresa específica
        $config = new Config([
            'empresa_id' => $empresa->id,
            'currency' => 'GTQ Q', // Reemplaza con los valores reales
            'currency_iso' => 'GTQ',
            'currency_simbol' => 'Q',
            'gracia' => '12',
        ]);
        $empresa->config()->save($config);

        // Crear 20 empresas adicionales usando el factory
        // Empresa::factory()->count(20)->create()->each(function ($empresa) {
            // Crear una configuración asociada a cada empresa
            // $config = new Config([
            //     'empresa_id' => $empresa->id,
            //     'currency' => 'GTQ Q', // Reemplaza con los valores reales
            //     'currency_iso' => 'GTQ',
            //     'currency_simbol' => 'Q',
            //     'gracia' => '3',
            // ]);

            // Asociar la configuración con la empresa
            // $empresa->config()->save($config);
        // });
    }
}

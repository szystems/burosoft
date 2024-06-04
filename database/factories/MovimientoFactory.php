<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Cuenta;
use App\Models\Rubro;

class MovimientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::where('empresa_id', 1)->inRandomOrder()->first();
        $empresa = Empresa::find(1);
        $cuenta = Cuenta::where('empresa_id', $empresa->id)->inRandomOrder()->first();
        $rubro = Rubro::where('empresa_id', $empresa->id)->inRandomOrder()->first();

        $monto_q = $this->faker->randomFloat(2, 1, 99999);
        $monto_d = $monto_q / 7.8;

        return [
            'fecha' => $this->faker->dateTimeBetween('-2 year', 'now')->format('Y-m-d'),
            'usuario_id' => $user->id,
            'empresa_id' => $empresa->id,
            'cuenta_id' => $cuenta->id,
            'rubro_id' => $rubro->id,
            'monto_q' => $monto_q,
            'monto_d' => $monto_d,
            'descripcion' => $this->faker->sentence,
        ];
    }
}

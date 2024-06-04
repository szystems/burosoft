<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CuentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'empresa_id' => $this->faker->numberBetween(1, 1),
            'nit' => $this->faker->numerify('########'),
            'dpi' => $this->faker->optional()->numerify('#############'),
            'razon_social' => $this->faker->company,
            'telefono' => $this->faker->optional()->numerify('########'),
            'correo' => $this->faker->unique()->safeEmail,
            'direccion' => $this->faker->optional()->address,
            'otra_forma_contacto' => $this->faker->optional()->phoneNumber,
            'datos_intermediario_nombre' => $this->faker->optional()->name,
            'datos_intermediario_telefono' => $this->faker->optional()->numerify('########'),
            'datos_intermediario_correo' => $this->faker->unique()->safeEmail,
            'datos_propietario_nombre' => $this->faker->optional()->name,
            'datos_propietario_telefono' => $this->faker->optional()->numerify('########'),
            'datos_propietario_correo' => $this->faker->unique()->safeEmail,
        ];
    }
}

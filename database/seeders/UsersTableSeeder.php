<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'empresa_id' => "1",
            'name' => 'Otto Szarata',
            'email' => 'szystems@hotmail.com',
            'password' => Hash::make('SPP7007aaa@@@'),
            'role_as' => 0,
            'estado' => 1,
            'principal' => 1,
        ]);

        User::create([
            'empresa_id' => "1",
            'name' => 'Otto Empresa',
            'email' => 'szotto18@hotmail.com',
            'password' => Hash::make('SPP7007aaa@@@'),
            'role_as' => 1,
            'estado' => 1,
            'principal' => 0,
        ]);

        User::create([
            'empresa_id' => "1",
            'name' => 'Byron de León',
            'email' => 'bdeleon@burotributario.com',
            'password' => Hash::make('bdeLeonBURO2024@@@'),
            'role_as' => 0,
            'estado' => 1,
            'principal' => 0,
        ]);

        User::create([
            'empresa_id' => "1",
            'name' => 'Rodolfo de León',
            'email' => 'rdeleon@burotributario.com',
            'password' => Hash::make('rdeLeonBURO2024@@@'),
            'role_as' => 0,
            'estado' => 1,
            'principal' => 0,
        ]);

        User::create([
            'empresa_id' => "1",
            'name' => 'Ingrid de León',
            'email' => 'ideleon@burotributario.com',
            'password' => Hash::make('ideLeonBURO2024@@@'),
            'role_as' => 0,
            'estado' => 1,
            'principal' => 0,
        ]);

        // User::factory()->count(100)->create();
    }
}

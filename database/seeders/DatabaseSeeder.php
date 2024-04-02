<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmpresaTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ConfigsTableSeeder::class);

        // $this->call(PaymentPlatformsTableSeeder::class);
        // $this->call(CurrenciesTableSeeder::class);
        // $this->call(PlanTableSeeder::class);
    }
}

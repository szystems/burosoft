<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Add3MesesToRtributaPlazoCatEnums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Agregar "3 meses" al ENUM de plazo_cat en tabla rtributas
        DB::statement("ALTER TABLE rtributas MODIFY COLUMN plazo_cat ENUM('5 días', '10 días', '15 días', '30 días', '45 días', '60 días', '3 meses', 'otro')");
        
        // Agregar "3 meses" al ENUM de plazo_cat en tabla rtributas_pa
        DB::statement("ALTER TABLE rtributas_pa MODIFY COLUMN plazo_cat ENUM('5 días', '10 días', '15 días', '30 días', '45 días', '60 días', '3 meses', 'otro')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revertir al ENUM original sin "3 meses" en tabla rtributas
        DB::statement("ALTER TABLE rtributas MODIFY COLUMN plazo_cat ENUM('5 días', '10 días', '15 días', '30 días', '45 días', '60 días', 'otro')");
        
        // Revertir al ENUM original sin "3 meses" en tabla rtributas_pa
        DB::statement("ALTER TABLE rtributas_pa MODIFY COLUMN plazo_cat ENUM('5 días', '10 días', '15 días', '30 días', '45 días', '60 días', 'otro')");
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixTipoResolucionEnumValues extends Migration
{
    /**
     * Run the migrations.
     * 
     * Corregir los valores ENUM de tipo_resolucion para que coincidan con el FormRequest
     * 
     * @return void
     */
    public function up()
    {
        // Actualizar registros existentes antes de cambiar la estructura
        DB::statement("UPDATE resolucions_pa SET tipo_resolucion = 'otro' WHERE tipo_resolucion = 'Otro'");
        DB::statement("UPDATE resolucions_pa SET tipo_resolucion = 'total a favor' WHERE tipo_resolucion = 'R-SAT'");

        // Actualizar la estructura ENUM para tipo_resolucion
        DB::statement("ALTER TABLE resolucions_pa MODIFY COLUMN tipo_resolucion ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revertir la estructura ENUM
        DB::statement("ALTER TABLE resolucions_pa MODIFY COLUMN tipo_resolucion ENUM('R-SAT', 'Otro') NOT NULL DEFAULT 'R-SAT'");
        
        // Revertir los valores
        DB::statement("UPDATE resolucions_pa SET tipo_resolucion = 'Otro' WHERE tipo_resolucion = 'otro'");
        DB::statement("UPDATE resolucions_pa SET tipo_resolucion = 'R-SAT' WHERE tipo_resolucion = 'total a favor'");
    }
}
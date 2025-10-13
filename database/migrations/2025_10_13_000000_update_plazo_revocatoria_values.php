<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdatePlazoRevocatoriaValues extends Migration
{
    /**
     * Run the migrations.
     * 
     * Actualizar valores existentes de plazo_revocatoria para usar el nuevo formato:
     * - "15 días" -> "10 D.H."
     * - "30 días" -> "30 D.H."
     * 
     * @return void
     */
    public function up()
    {
        // Primero actualizar registros existentes con valores antiguos
        DB::statement("UPDATE resolucions_pa SET plazo_revocatoria = '10 D.H.' WHERE plazo_revocatoria = '15 días'");
        DB::statement("UPDATE resolucions_pa SET plazo_revocatoria = '30 D.H.' WHERE plazo_revocatoria = '30 días'");

        // Actualizar la estructura ENUM usando raw SQL para evitar el requisito de doctrine/dbal
        DB::statement("ALTER TABLE resolucions_pa MODIFY COLUMN plazo_revocatoria ENUM('5 D.H.', '10 D.H.', '30 D.H.', 'otro') NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revertir la estructura ENUM primero
        DB::statement("ALTER TABLE resolucions_pa MODIFY COLUMN plazo_revocatoria ENUM('15 días', '30 días', 'otro') NULL");
        
        // Luego revertir los valores al formato anterior
        DB::statement("UPDATE resolucions_pa SET plazo_revocatoria = '15 días' WHERE plazo_revocatoria = '10 D.H.'");
        DB::statement("UPDATE resolucions_pa SET plazo_revocatoria = '30 días' WHERE plazo_revocatoria = '30 D.H.'");
    }
}
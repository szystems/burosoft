<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNulidadesPaTableAddDatetimeAndFechaResolucion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Primero eliminamos la columna fecha
        Schema::table('nulidades_pa', function (Blueprint $table) {
            $table->dropColumn('fecha');
        });
        
        // Luego agregamos los nuevos campos
        Schema::table('nulidades_pa', function (Blueprint $table) {
            $table->datetime('fecha_hora_notificacion')->after('usuario_id');
            $table->date('fecha_resolucion')->nullable()->after('numero_resolucion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nulidades_pa', function (Blueprint $table) {
            $table->dropColumn(['fecha_hora_notificacion', 'fecha_resolucion']);
        });
        
        Schema::table('nulidades_pa', function (Blueprint $table) {
            $table->date('fecha')->after('usuario_id');
        });
    }
}

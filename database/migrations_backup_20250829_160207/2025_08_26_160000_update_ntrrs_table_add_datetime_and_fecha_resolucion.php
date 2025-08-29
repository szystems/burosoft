<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNtrrsTableAddDatetimeAndFechaResolucion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ntrrs', function (Blueprint $table) {
            // Cambiar el campo 'fecha' a 'fecha_hora_notificacion' (DATETIME)
            $table->dropColumn('fecha');
        });

        Schema::table('ntrrs', function (Blueprint $table) {
            // Agregar los nuevos campos
            $table->dateTime('fecha_hora_notificacion')->after('id');
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
        Schema::table('ntrrs', function (Blueprint $table) {
            $table->dropColumn(['fecha_hora_notificacion', 'fecha_resolucion']);
        });

        Schema::table('ntrrs', function (Blueprint $table) {
            $table->date('fecha')->after('id');
        });
    }
}

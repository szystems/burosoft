<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaNotificacionAndFechaResolucionToResolucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resolucions', function (Blueprint $table) {
            // Agregar nuevo campo para fecha y hora de notificación (datetime)
            $table->dateTime('fecha_notificacion')->nullable()->after('fecha');
            
            // Agregar el nuevo campo fecha_resolucion
            $table->date('fecha_resolucion')->nullable()->after('fecha_notificacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resolucions', function (Blueprint $table) {
            $table->dropColumn(['fecha_notificacion', 'fecha_resolucion']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEcsPaTableAddDatetimeAndFechaResolucion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ecs_pa', function (Blueprint $table) {
            $table->datetime('fecha_hora_notificacion')->nullable()->after('numero_resolucion');
            $table->date('fecha_resolucion')->nullable()->after('fecha_hora_notificacion');
            $table->string('juzgado_que_conoce')->nullable()->after('fecha_resolucion');
            $table->json('medidas_decretadas')->nullable()->after('juzgado_que_conoce');
            $table->string('medidas_decretadas_otro')->nullable()->after('medidas_decretadas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ecs_pa', function (Blueprint $table) {
            $table->dropColumn(['fecha_hora_notificacion', 'fecha_resolucion', 'juzgado_que_conoce', 'medidas_decretadas', 'medidas_decretadas_otro']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteEcsPaTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_07_21_100008_create_ecs_pa_table.php (estructura base)
     * - update_ecs_pa_table_add_datetime_and_fecha_resolucion.php (datetime + fecha_resolucion)
     * - add_juzgado_and_medidas_to_ecs_pa_table.php (juzgado + medidas)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecs_pa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audiencia_pa_id');
            $table->text('numero_resolucion');
            // Campos datetime consolidados
            $table->datetime('fecha_hora_notificacion')->nullable();
            $table->date('fecha_resolucion')->nullable();
            // Campos de juzgado y medidas (evitando duplicación)
            $table->string('juzgado_que_conoce')->nullable();
            $table->json('medidas_decretadas')->nullable();
            $table->string('medidas_decretadas_otro')->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->integer('numero_folios')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('audiencia_pa_id')->references('id')->on('audiencias_pa')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecs_pa');
    }
}

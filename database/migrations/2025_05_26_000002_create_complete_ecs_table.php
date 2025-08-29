<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_05_26_000002_create_ecs_table.php (estructura base)
     * - 2025_08_26_130000_update_ecs_table_add_datetime_and_fecha_resolucion.php (campos datetime + juzgado + medidas)
     * - 2025_08_26_140000_add_juzgado_and_medidas_to_ecs_table.php (duplicaba campos de la anterior)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audiencia_id');
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
            $table->foreign('audiencia_id')->references('id')->on('audiencias')->onDelete('cascade');
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
        Schema::dropIfExists('ecs');
    }
};

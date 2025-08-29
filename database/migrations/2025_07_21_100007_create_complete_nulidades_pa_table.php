<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteNulidadesPaTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_07_21_100007_create_nulidades_pa_table.php (estructura base)
     * - 2025_08_26_120100_update_nulidades_pa_table_add_datetime_and_fecha_resolucion.php (datetime + fecha_resolucion)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nulidades_pa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audiencia_pa_id')->constrained('audiencias_pa')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            // Campo fecha cambiado a datetime según update
            $table->datetime('fecha_hora_notificacion');
            $table->string('numero_resolucion');
            // Campo fecha_resolucion añadido
            $table->date('fecha_resolucion')->nullable();
            $table->string('archivo');
            $table->string('tipo_archivo');
            $table->text('observaciones')->nullable();
            $table->enum('tipo_nulidad', ['Absoluta', 'Relativa']);
            $table->integer('numero_folios')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nulidades_pa');
    }
}

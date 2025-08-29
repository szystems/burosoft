<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteNulidadesTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_05_26_000001_create_nulidades_table.php (estructura base)
     * - 2025_08_26_120000_update_nulidades_table_add_datetime_and_fecha_resolucion.php (datetime + fecha_resolucion)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nulidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audiencia_id')->constrained('audiencias')->onDelete('cascade');
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
        Schema::dropIfExists('nulidades');
    }
}

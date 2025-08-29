<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteNtrrsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_03_20_000000_create_ntrrs_table.php (estructura base)
     * - 2025_08_26_160000_update_ntrrs_table_add_datetime_and_fecha_resolucion.php (datetime + fecha_resolucion)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ntrrs', function (Blueprint $table) {
            $table->id();
            // Campo fecha cambiado a datetime según update
            $table->dateTime('fecha_hora_notificacion');
            $table->string('numero_resolucion');
            // Campo fecha_resolucion añadido
            $table->date('fecha_resolucion')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('audiencia_id');
            $table->string('archivo')->nullable();
            $table->string('tipo_archivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('numero_folios')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('audiencia_id')->references('id')->on('audiencias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ntrrs');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletePpsPaTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_07_21_100002_create_pps_pa_table.php (estructura base)
     * - 2025_08_22_000004_add_oficina_presentacion_to_pps_pa_table.php (campo oficina)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pps_pa', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_hora_presentacion');
            $table->string('numero_documento');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('audiencia_pa_id');
            $table->string('archivo')->nullable();
            $table->string('tipo_archivo')->nullable();
            $table->text('observaciones')->nullable();
            // Campo oficina_presentacion consolidado
            $table->string('oficina_presentacion')->nullable();
            $table->integer('numero_folios')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('audiencia_pa_id')->references('id')->on('audiencias_pa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pps_pa');
    }
}

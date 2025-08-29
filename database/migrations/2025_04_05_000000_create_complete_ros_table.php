<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteRosTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_04_05_000000_create_ros_table.php (estructura base)
     * - 2025_08_28_180000_add_fecha_notificacion_and_fecha_resolucion_to_ros_table.php (campos fecha adicionales)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ros', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            // Campos fecha adicionales consolidados
            $table->dateTime('fecha_notificacion')->nullable();
            $table->date('fecha_resolucion')->nullable();
            $table->string('numero_resolucion');
            $table->enum('tipo_resolucion', ['Procede tramite', 'No procede tramite']);
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
        Schema::dropIfExists('ros');
    }
}

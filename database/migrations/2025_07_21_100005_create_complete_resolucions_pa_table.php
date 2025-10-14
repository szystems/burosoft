<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteResolucionsPaTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas de resolucions_pa:
     * - 2025_07_21_100005_create_resolucions_pa_table.php (estructura base)
     * - 2025_10_13_000000_update_plazo_revocatoria_values.php (plazo_revocatoria corregido)
     * - 2025_10_13_000001_fix_tipo_resolucion_enum_values.php (tipo_resolucion corregido)
     * - migraciones adicionales para campos tipo_resolucion, fechas, etc.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolucions_pa', function (Blueprint $table) {
            $table->id();
            $table->string('numero_resolucion');
            // Campo tipo_resolucion consolidado con todos los valores posibles
            $table->enum('tipo_resolucion', [
                'total a favor', 
                'total en contra', 
                'parcial', 
                'nulidad', 
                'penal', 
                'otro'
            ])->nullable();
            $table->string('tipo_resolucion_otro')->nullable();
            $table->enum('plazo_revocatoria', ['5 D.H.', '10 D.H.', '30 D.H.', 'otro'])->nullable();
            $table->string('plazo_revocatoria_otro')->nullable();
            $table->date('fecha');
            // Campos de fecha consolidados
            $table->dateTime('fecha_notificacion')->nullable();
            $table->date('fecha_resolucion')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('audiencia_pa_id');
            $table->string('archivo')->nullable();
            $table->string('tipo_archivo')->nullable();
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('resolucions_pa');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteAudienciasPaTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_07_21_100000_create_audiencias_pa_table.php (estructura base)
     * - 2025_08_21_114001_add_notificacion_fields_to_audiencias_pa_table.php (campos notificación)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audiencias_pa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pat_id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('numero_audiencia');
            $table->enum('tipo_audiencia', ['AEC', 'AIR', 'AS', 'AA', 'Otro']);
            $table->string('tipo_audiencia_otro')->nullable(); // Si tipo_audiencia es "Otro"
            $table->dateTime('fecha');
            $table->decimal('impuestos', 15, 2);
            $table->string('archivo')->nullable();
            $table->string('tipo_archivo')->nullable();
            // Campos de notificación consolidados
            $table->date('fecha_notificacion')->nullable();
            $table->enum('plazo_evacuar', ['5 Dias', '10 Dias', '30 Dias', 'Otro'])->nullable();
            $table->string('plazo_evacuar_otro')->nullable(); // Si es "Otro"
            $table->timestamps();

            // Foreign keys
            $table->foreign('pat_id')->references('id')->on('pats')->onDelete('cascade');
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
        Schema::dropIfExists('audiencias_pa');
    }
}

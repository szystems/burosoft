<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteAudienciasTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_02_25_114400_create_audiencias_table.php (estructura base)
     * - 2025_08_21_114000_add_notificacion_fields_to_audiencias_table.php (campos notificación)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audiencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pat_id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('numero_audiencia');
            $table->enum('tipo_audiencia', ['AEC', 'AIR', 'AS', 'AA']);
            $table->dateTime('fecha');
            $table->decimal('impuestos', 15, 2);
            $table->string('archivo')->nullable();
            $table->string('tipo_archivo')->nullable();
            // Campos de notificación consolidados
            $table->date('fecha_notificacion')->nullable();
            $table->string('plazo_evacuar')->nullable(); // 5 D.H., 10 D.H., 30 D.H., Otro
            $table->string('plazo_evacuar_otro')->nullable(); // Si es "Otro"
            $table->timestamps();

            // Foreign keys
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            // Nota: pat_id parece referenciar tabla 'pats' pero necesita verificación
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audiencias');
    }
}

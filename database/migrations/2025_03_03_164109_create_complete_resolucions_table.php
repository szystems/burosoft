<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteResolucionsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_03_03_164109_create_resolucions_table.php (estructura base)
     * - 2025_03_15_000000_add_tipo_resolucion_to_resolucions_table.php (enum tipo_resolucion)
     * - 2025_08_22_100000_update_resolucions_table_add_new_fields.php (campos adicionales + enum ampliado)
     * - 2025_08_28_170000_modify_fecha_and_add_fecha_resolucion_to_resolucions_table.php (vacía)
     * - 2025_08_28_170200_add_fecha_notificacion_and_fecha_resolucion_to_resolucions_table.php (campos fecha)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolucions', function (Blueprint $table) {
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
        Schema::dropIfExists('resolucions');
    }
}

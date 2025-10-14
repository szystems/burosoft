<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteRtributasPaTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_07_21_100006_create_rtributas_pa_table.php (estructura base)
     * - 2025_08_22_102001_update_rtributas_pa_table_add_new_fields.php (campos adicionales + datetime)
     * - 2025_08_22_232132_update_rtributas_pa_plazo_cat_enum.php (vacía)
     * - 2025_08_22_232500_fix_rtributas_pa_plazo_cat_enum.php (fix del enum plazo_cat)
     * - 2025_10_13_130111_add_3_meses_to_rtributa_plazo_cat_enums.php (opción "3 meses" agregada)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rtributas_pa', function (Blueprint $table) {
            $table->id();
            // Campo fecha modificado a datetime según update
            $table->datetime('fecha_hora_notificacion');
            $table->string('numero_resolucion');
            $table->date('fecha_resolucion')->nullable();
            // Enum tipo_resolucion ampliado con 'otro'
            $table->enum('tipo_resolucion', [
                'total a favor', 
                'total en contra', 
                'parcial', 
                'nulidad', 
                'penal', 
                'otro'
            ]);
            $table->string('tipo_resolucion_otro')->nullable();
            // Enum plazo_cat con valores corregidos del fix
            $table->enum('plazo_cat', [
                '5 días', 
                '10 días', 
                '15 días', 
                '30 días', 
                '45 días', 
                '60 días', 
                '3 meses',
                'otro'
            ])->nullable();
            $table->string('plazo_cat_otro')->nullable();
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
        Schema::dropIfExists('rtributas_pa');
    }
}

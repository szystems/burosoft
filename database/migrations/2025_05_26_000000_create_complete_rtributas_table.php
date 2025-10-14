<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteRtributasTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_05_26_000000_create_rtributas_table.php (estructura base)
     * - 2025_08_22_102000_update_rtributas_table_add_new_fields.php (campos adicionales + datetime)
     * - 2025_08_22_232600_fix_rtributas_va_plazo_cat_enum.php (fix del enum plazo_cat)
     * - 2025_10_13_130111_add_3_meses_to_rtributa_plazo_cat_enums.php (opción "3 meses" agregada)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rtributas', function (Blueprint $table) {
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
        Schema::dropIfExists('rtributas');
    }
}

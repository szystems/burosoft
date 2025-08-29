<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteMpmrsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_04_10_000000_create_mpmrs_table.php (estructura base)
     * - 2025_08_28_111017_add_fecha_resolucion_to_mpmrs_table.php (campo fecha_resolucion)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpmrs', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha_hora');
            // Campo fecha_resolucion consolidado
            $table->date('fecha_resolucion')->nullable();
            $table->string('numero_resolucion');
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
        Schema::dropIfExists('mpmrs');
    }
}

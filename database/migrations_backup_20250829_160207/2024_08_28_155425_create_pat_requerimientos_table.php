<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pat_requerimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pat_id');
            $table->string('no');
            $table->date('fecha');
            $table->date('fecha_maxima');
            $table->string('tipo_requerimiento');
            $table->string('tipo_requerimiento_otro')->nullable();
            $table->string('lugar_atender');
            $table->string('lugar_atender_otro')->nullable();
            $table->string('domicilio');
            $table->string('plazo_atencion');
            $table->string('tipo_revision');
            $table->string('tipo_revision_otro')->nullable();
            $table->string('archivo');
            $table->string('tipo');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pat_requerimientos');
    }
}

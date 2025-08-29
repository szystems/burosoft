<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatRctsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pat_rcts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pat_id');
            $table->date('fecha_citacion');
            $table->string('medio_citacion'); // Escrita, Hablada, Otro
            $table->string('medio_citacion_otro')->nullable(); // Si es "Otro"
            $table->date('fecha_atencion');
            $table->text('participantes_reunion');
            $table->string('lugar_celebracion');
            $table->text('descripcion_resultado');
            $table->string('suscribe_acta'); // Si, No
            $table->string('archivo_acta')->nullable(); // Si suscribe acta = Si
            $table->string('tipo_archivo_acta')->nullable(); // Tipo del archivo del acta
            $table->string('archivo_recibo_pago')->nullable(); // Archivo opcional
            $table->string('tipo_archivo_recibo')->nullable(); // Tipo del archivo del recibo
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
        Schema::dropIfExists('pat_rcts');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatAtencionRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pat_atencion_requerimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pat_id');
            $table->string('no');
            $table->date('fecha');
            $table->enum('forma_atencion', ['Escrito', 'Verbal', 'Otro']);
            $table->string('forma_atencion_otro')->nullable();
            $table->enum('acta_administrativa', ['Si', 'No']);
            $table->string('quien_atendio', 100);
            $table->text('observaciones')->nullable();
            $table->string('archivo')->nullable();
            $table->string('tipo')->nullable();
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
        Schema::dropIfExists('pat_atencion_requerimientos');
    }
}

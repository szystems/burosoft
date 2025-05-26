<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRtributasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rtributas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_resolucion');
            $table->date('fecha');
            $table->enum('tipo_resolucion', ['total a favor', 'total en contra', 'parcial', 'nulidad', 'penal']);
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('audiencia_id');
            $table->string('archivo')->nullable();
            $table->string('tipo_archivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

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

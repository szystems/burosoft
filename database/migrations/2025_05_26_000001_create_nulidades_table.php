<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNulidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nulidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audiencia_id')->constrained('audiencias')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->date('fecha');
            $table->string('numero_resolucion');
            $table->string('archivo');
            $table->string('tipo_archivo');            $table->text('observaciones')->nullable();
            $table->enum('tipo_nulidad', ['Absoluta', 'Relativa']);
            $table->integer('numero_folios')->nullable();
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
        Schema::dropIfExists('nulidades');
    }
}

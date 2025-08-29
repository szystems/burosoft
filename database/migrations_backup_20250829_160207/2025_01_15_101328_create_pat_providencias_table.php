<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatProvidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pat_providencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pat_id');
            $table->string('no');
            $table->date('fecha');
            $table->string('tipo_providencia');
            $table->string('tipo_providencia_otro')->nullable();
            $table->string('admite');
            $table->string('admite_otro')->nullable();
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('pat_providencias');
    }
}

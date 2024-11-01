<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatActaAdministrativasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pat_acta_administrativas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pat_id');
            $table->date('fecha');
            $table->text('quienes_intervinieron')->nullable();
            $table->enum('tipo_acta', ['Limpia', 'Con Acuerdo','De Inconformidad' , 'Otro']);
            $table->string('tipo_acta_otro')->nullable();
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
        Schema::dropIfExists('pat_acta_administrativas');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatNotificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pat_notificacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pat_id');
            $table->date('fecha');
            $table->time('hora');
            $table->string('tipo_notificacion')->nullable();
            $table->string('recibio')->nullable();
            $table->string('domicilio_notificacion')->nullable();
            $table->string('domicilio_notificacion_es')->nullable();
            $table->string('domicilio_notificacion_otro')->nullable();
            $table->string('persona_idonea')->nullable();
            $table->integer('folios_notificados')->default(0);
            $table->string('acto_notificado');
            $table->string('plazo_atencion');
            $table->date('vencimiento_plazo');
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
        Schema::dropIfExists('pat_notificacions');
    }
}

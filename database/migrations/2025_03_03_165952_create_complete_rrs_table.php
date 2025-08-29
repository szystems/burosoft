<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteRrsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida las siguientes migraciones fragmentadas:
     * - 2025_03_03_165952_create_rrs_table.php (estructura base)
     * - 2025_08_26_150000_add_oficina_agencia_ea_to_rrs_table.php (campo oficina_agencia_ea)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_hora_presentacion');
            $table->string('numero_documento');
            // Campo oficina_agencia_ea consolidado
            $table->string('oficina_agencia_ea', 300)->nullable();
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
        Schema::dropIfExists('rrs');
    }
}

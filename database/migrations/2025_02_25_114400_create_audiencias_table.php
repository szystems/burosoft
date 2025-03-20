<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudienciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audiencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pat_id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('numero_audiencia');
            $table->enum('tipo_audiencia', ['AEC', 'AIR', 'AS', 'AA']);
            $table->dateTime('fecha');
            $table->decimal('impuestos', 8, 2);
            $table->string('archivo')->nullable();
            $table->string('tipo_archivo')->nullable();
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
        Schema::dropIfExists('audiencias');
    }
}

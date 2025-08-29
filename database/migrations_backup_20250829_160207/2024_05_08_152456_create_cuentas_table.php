<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('empresa_id');
            $table->string('nit');
            $table->string('dpi')->nullable();
            $table->string('razon_social');
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('direccion')->nullable();
            $table->string('otra_forma_contacto')->nullable();
            $table->string('datos_intermediario_nombre')->nullable();
            $table->string('datos_intermediario_telefono')->nullable();
            $table->string('datos_intermediario_correo')->nullable();
            $table->string('datos_propietario_nombre')->nullable();
            $table->string('datos_propietario_telefono')->nullable();
            $table->string('datos_propietario_correo')->nullable();
            $table->string('codigo');
            $table->boolean('estado')->default(1);
            $table->timestamps();

            // Crear un índice único que combine empresa_id y codigo
            $table->unique(['empresa_id', 'codigo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuentas');
    }
}

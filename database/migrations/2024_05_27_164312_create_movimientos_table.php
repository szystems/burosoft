<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('empresa_id');
            $table->unsignedInteger('cuenta_id');
            $table->unsignedInteger('rubro_id');
            $table->decimal('monto_q', 8, 2)->default(0.00);
            $table->decimal('monto_d', 8, 2)->default(0.00);
            $table->text('descripcion')->nullable();
            $table->string('codigo');
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('movimientos');
    }
}

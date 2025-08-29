<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaResolucionToMpmrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mpmrs', function (Blueprint $table) {
            $table->date('fecha_resolucion')->nullable()->after('fecha_hora');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mpmrs', function (Blueprint $table) {
            $table->dropColumn('fecha_resolucion');
        });
    }
}

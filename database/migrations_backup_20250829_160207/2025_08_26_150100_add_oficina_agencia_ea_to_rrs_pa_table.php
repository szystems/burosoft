<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOficinaAgenciaEaToRrsPaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrs_pa', function (Blueprint $table) {
            $table->string('oficina_agencia_ea', 300)->nullable()->after('numero_documento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrs_pa', function (Blueprint $table) {
            $table->dropColumn('oficina_agencia_ea');
        });
    }
}

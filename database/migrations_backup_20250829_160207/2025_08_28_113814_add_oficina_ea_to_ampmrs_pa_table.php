<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOficinaEaToAmpmrsPaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ampmrs_pa', function (Blueprint $table) {
            $table->string('oficina_ea')->nullable()->after('numero_documento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ampmrs_pa', function (Blueprint $table) {
            $table->dropColumn('oficina_ea');
        });
    }
}

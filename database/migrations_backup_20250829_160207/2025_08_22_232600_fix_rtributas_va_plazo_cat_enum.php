<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixRtributasVaPlazoCatEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Primero eliminamos la columna plazo_cat de la tabla rtributas (VA)
        Schema::table('rtributas', function (Blueprint $table) {
            $table->dropColumn('plazo_cat');
        });
        
        // Luego la recreamos con los valores correctos
        Schema::table('rtributas', function (Blueprint $table) {
            $table->enum('plazo_cat', ['5 días', '10 días', '15 días', '30 días', '45 días', '60 días', 'otro'])
                  ->nullable()
                  ->after('tipo_resolucion_otro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revertir al estado anterior
        Schema::table('rtributas', function (Blueprint $table) {
            $table->dropColumn('plazo_cat');
        });
        
        Schema::table('rtributas', function (Blueprint $table) {
            $table->enum('plazo_cat', ['30 D.H.', '3 Meses', 'otro'])
                  ->nullable()
                  ->after('tipo_resolucion_otro');
        });
    }
}

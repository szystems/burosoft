<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificacionFieldsToAudienciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audiencias', function (Blueprint $table) {
            $table->date('fecha_notificacion')->nullable()->after('tipo_archivo');
            $table->string('plazo_evacuar')->nullable()->after('fecha_notificacion'); // 5 D.H., 10 D.H., 30 D.H., Otro
            $table->string('plazo_evacuar_otro')->nullable()->after('plazo_evacuar'); // Si es "Otro"
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audiencias', function (Blueprint $table) {
            $table->dropColumn(['fecha_notificacion', 'plazo_evacuar', 'plazo_evacuar_otro']);
        });
    }
}

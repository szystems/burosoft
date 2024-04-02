<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('currency');
            $table->string('currency_iso');
            $table->string('currency_simbol');
            $table->tinyInteger('paypal')->default('0');
            $table->tinyInteger('dbt')->default('0');
            $table->decimal('shipping', $precision = 11, $scale = 2)->default('0.00');
            $table->mediumText('shipping_description')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('configs');
    }
}

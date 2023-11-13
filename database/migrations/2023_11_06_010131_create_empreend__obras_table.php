<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empreend__obras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obra_id')->references('id')->on('obras');
            $table->foreignId('empreendimento_id')->references('id')->on('empreendimentos');
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
        Schema::dropIfExists('empreend__obras');
    }
};

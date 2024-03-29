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
        Schema::create('iniciativas', function (Blueprint $table) {
            $table->id();            
            $table->string('nome');
            $table->string('responsavel');
            $table->string('ele_principal_afetado');
            $table->string('expectativa');
            $table->boolean('status')->default(true);
            $table->string('instrumento');
            $table->foreignId('setor')->references('id')->on('setors');
            $table->foreignId('usuario')->references('id')->on('users');
            $table->string('usuario_alteracao')->nullable();
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
        Schema::dropIfExists('iniciativas');
    }
};

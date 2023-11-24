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
            $table->string('instrumento');
            $table->foreignId('usuario')->references('id')->on('users');
            $table->unsignedBigInteger('status')->nullable();
            $table->foreign('status')->references('id')->on('statuses');
            $table->unsignedBigInteger('setor')->nullable();
            $table->foreign('setor')->references('id')->on('setors');
            $table->unsignedBigInteger('usuario_que_alterou')->nullable();
            $table->foreign('usuario_que_alterou')->references('id')->on('users');

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

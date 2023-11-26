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
        Schema::create('empreendimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('responsavel');
            $table->string('obras')->nullable();
            $table->foreignId('user')->references('id')->on('users');     
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('empreendimentos');
    }
};

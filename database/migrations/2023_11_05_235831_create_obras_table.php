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
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('respondente');
            $table->string('descricao');
            $table->string('intervencao');
            $table->foreignId('tipo_infraestrutura')->references('id')->on('tipo_infraestruturas');
            $table->date('data_inicio');
            $table->date('data_conclusao');
            $table->date('data_orcamento');
            $table->float('valor_global');
            $table->float('finan_executada');
            $table->boolean('status');
            $table->string('instrumento');
            $table->string('doc_adicionais');
            $table->foreignId('endereco')->references('id')->on('enderecos')->onDelete('cascade');
            $table->string('arq_georeferenciado');
            $table->foreignId('empreendimento')->constrained()->onDelete('cascade');
            $table->string('tipo');
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
        Schema::dropIfExists('obras');
    }
};

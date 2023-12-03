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
        Schema::create('obra_produtos', function (Blueprint $table) {
            $table->unsignedBigInteger('obra');
            $table->unsignedBigInteger('produto');
            $table->primary(['obra', 'produto']); // Composite primary key
        
            // Foreign key constraints
            $table->foreign('obra')->references('id')->on('obras')->onDelete('cascade');
            $table->foreign('produto')->references('id')->on('produtos')->onDelete('cascade');
        
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
        Schema::dropIfExists('obra_produtos');
    }
};

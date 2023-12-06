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
        Schema::create('obra_produto', function (Blueprint $table) {
            $table->unsignedBigInteger('obra_id');
            $table->unsignedBigInteger('produto_id');
            $table->primary(['obra_id', 'produto_id']); // Composite primary key
        
            // Foreign key constraints
            $table->foreign('obra_id')->references('id')->on('obras')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
        
            $table->timestamps();
        });

        // Schema::table('obra_produto', function(Blueprint $table) {
        //     $table->renameColumn('obra', 'obra_id');
        //     $table->renameColumn('produto', 'produto_id');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obra_produto');
    }
};

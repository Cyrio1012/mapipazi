<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_descent')->nullable(); // ID_DESCENT
            $table->string('designation');            // DESIGNATION
            $table->string('marque')->nullable();     // MARQUE
            $table->string('type')->nullable();       // TYPE
            $table->string('imm')->nullable();        // IMM
            $table->string('volume')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matros');
    }
};

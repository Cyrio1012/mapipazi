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
        Schema::create('proprietes', function (Blueprint $table) {
            $table->id(); // ID
            $table->foreignId('id_descent')->constrained('descentes')->onDelete('cascade'); // ID_DESCENT

            $table->decimal('x', 12, 6)->nullable(); // X
            $table->decimal('y', 12, 6)->nullable(); // Y
            $table->string('titre')->nullable(); // TITRE
            $table->string('plle')->nullable(); // PLLE
            $table->string('imm')->nullable(); // IMM
            $table->decimal('superficie', 10, 3)->nullable(); // 
            $table->decimal('sup_remblais', 10, 3)->nullable(); // 
            $table->string('comm_desc')->nullable(); // COMM_DESC
            $table->string('pu')->nullable(); // PU
            $table->enum('zone', ['zc', 'zi', 'zd']); // ZONE
            $table->enum('destination', ['h', 'c']); // DESTINATION

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proprietes');
    }
};

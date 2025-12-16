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
        Schema::create('doleances', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('contact')->nullable();
            $table->string('sujet')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['nouveau', 'en_cours', 'traite', 'rejete'])->default('nouveau');
            $table->foreignId('traiteur_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('reponse')->nullable();
            $table->timestamp('traite_le')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doleances');
    }
};

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
        Schema::create('aps', function (Blueprint $table) {
            $table->id(); // ID
            $table->foreignId('id_descent')->constrained('descentes')->onDelete('cascade'); // ID_DESCENT
            $table->string('num_ap')->nullable(); // NUM_AP
            $table->string('nom_proprietaire')->nullable(); // NUM_AP
            $table->string('type')->nullable(); // TYPE
            $table->date('date_ap')->nullable(); // DATE_AP
            $table->decimal('sup_remblais', 10, 2)->nullable(); // SUP_REMBLAIS
            $table->string('comm_propriete')->nullable(); // COMM_PROPRIETE
            
            $table->string('x')->nullable(); // PU
            $table->string('y')->nullable(); // PU
            $table->string('fkt')->nullable(); // PU
            $table->enum('zone', ['zc', 'zi', 'zd']); // ZONE
            $table->string('titre')->nullable(); // PU
            $table->string('imm')->nullable(); // PU
            $table->enum('destination', ['h', 'c']); // DESTINATION
            $table->integer('taux')->nullable(); // TAUX
            $table->integer('taux_payer')->nullable(); // TAUX
            $table->date('notifier')->nullable(); // DATE_AP
            $table->integer('delais_md')->nullable(); // DATE_AP
            $table->string('situation')->nullable(); // SITUATION

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aps');
    }
};

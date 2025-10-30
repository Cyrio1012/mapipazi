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
        Schema::create('descentes', function (Blueprint $table) {
            $table->id(); // ID
            $table->date('date')->nullable(); // DATE
            $table->time('heure')->nullable(); // HEURE

            $table->string('ref_om')->nullable(); // REF_OM
            $table->enum('ref_pv',['pat','fifafi']); // REF_PV
            $table->string('ref_rapport')->nullable(); // REF_RAPPORT
            $table->string('num_pv')->nullable(); // NUM_PV

            $table->json('equipe')->nullable(); // EQUIPE
            $table->json('action')->nullable(); // ACTION
            $table->json('constat')->nullable(); // CONSTAT

            $table->string('pers_verb')->nullable(); // PERS_VERB
            $table->string('qte_pers')->nullable(); // Qte_PERS

            $table->string('adresse')->nullable(); // ADRESSE
            $table->string('contact')->nullable(); // CONTACT

            $table->string('dist')->nullable(); // DIST
            $table->string('comm')->nullable(); // COMM
            $table->string('fkt')->nullable(); // FKT

            $table->double('x')->nullable(); // X (longitude)
            $table->double('y')->nullable(); // Y (latitude)

            $table->date('date_rdv_ft')->nullable(); // DATE_RDV_FT
            $table->time('heure_rdv_ft')->nullable(); // HEURE_RDV_FT

            $table->json('pieces_a_fournir')->nullable(); // PIECES_A_FOURNIR
            $table->json('pieces_fournis')->nullable(); // PIECES_FOURNIS

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descentes');
    }
};

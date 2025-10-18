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
        Schema::create('fts', function (Blueprint $table) {
       	    $table->id(); // ID
            $table->foreignId('id_descent')->constrained('descentes')->onDelete('cascade'); // ID_DESCENT

            $table->date('date')->nullable(); // DATE
            $table->time('heure')->nullable(); // HEURE

            $table->string('num_ft')->nullable(); // NUM_FT
            $table->string('antony_ft')->nullable(); // MOTIF_FT

            $table->json('constat_desc')->nullable(); // CONSTAT_DESC
            $table->string('dist_desc')->nullable(); // DIST_DESC
            $table->string('comm_desc')->nullable(); // COMM_DESC
            $table->string('fkt_desc')->nullable(); // FKT_DESC
            $table->string('pu')->nullable(); // FKT_DESC
            $table->enum('zone', ['zc', 'zi','zd']);
            $table->enum('destination', ['h', 'c']);

            $table->decimal('x_desc', 12, 6)->nullable(); // X_DESC
            $table->decimal('y_desc', 12, 6)->nullable(); // Y_DESC

            $table->text('objet_ft')->nullable(); // OBJET_FT

            $table->string('nom_pers_venue')->nullable(); // NOM_PERS_VENUE
            $table->string('qte_pers_venue')->nullable(); // Qte_PERS_VENUE
            $table->string('contact')->nullable(); // CONTACT
            $table->string('adresse')->nullable(); // ADRESSE
            $table->string('cin')->nullable(); // CIN

            $table->json('pieces_apporter')->nullable(); // PIECES_APPORTER
            $table->text('recommandation')->nullable(); // RECOMMANDATION
            $table->json('pieces_complement')->nullable(); // PIECES_COMPLEMENT

            $table->string('delais')->nullable(); // DELAIS
            $table->date('date_rdv_ft')->nullable(); // DATE_RDV_FT
            $table->time('heure_rdv_ft')->nullable(); // HEURE_RDV_FT

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fts');
    }
};

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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id(); // id
            $table->string('xv')->nullable(); // xv
            $table->string('yv')->nullable(); // yv
            $table->string('upr')->nullable(); // upr
            $table->string('sit_r')->nullable(); // sit_r
            $table->string('exoyear')->nullable(); // exoyear
            $table->string('opfinal')->nullable(); // opfinal
            $table->string('category')->nullable(); // category
            $table->string('locality')->nullable(); // locality
            $table->string('arrivalid')->nullable(); // arrivalid
            $table->string('sendersce')->nullable(); // sendersce
            $table->date('arrivaldate')->nullable(); // arrivaldate
            $table->string('invoicingid')->nullable(); // invoicingid
            $table->decimal('surfacearea', 10, 2)->nullable(); // surfacearea
            $table->string('municipality')->nullable(); // municipality
            $table->string('propertyname')->nullable(); // propertyname
            $table->decimal('roaltyamount', 10, 2)->nullable(); // roaltyamount
            $table->string('applicantname')->nullable(); // applicantname
            $table->date('invoicingdate')->nullable(); // invoicingdate
            $table->date('opiniondfdate')->nullable(); // opiniondfdate
            $table->string('propertyowner')->nullable(); // property0wner (corrigé en propertyowner)
            $table->string('propertytitle')->nullable(); // propertytitle
            $table->decimal('backfilledarea', 10, 2)->nullable(); // backfilledarea
            $table->date('commissiondate')->nullable(); // commissiondate
            $table->text('applicantaddress')->nullable(); // applicantaddress
            $table->text('commissionopinion')->nullable(); // commissionopinion
            $table->text('urbanplanningregulations')->nullable(); // urbanplanningregulations
            
            // Timestamps standards
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('arrivalid');
            $table->index('invoicingid');
            $table->index('applicantname');
            $table->index('arrivaldate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};

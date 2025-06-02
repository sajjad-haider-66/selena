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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_number')->unique(); // N° A 658702
            $table->string('main_enterprise_1')->nullable(); // Enterprise principale
            $table->string('subcontractor_1')->nullable(); // Enterprise principale
            $table->string('speaker_1')->nullable(); // Enterprise principale
            $table->string('main_enterprise_2')->nullable(); // Enterprise sous-traitante
            $table->string('subcontractor_2')->nullable(); // Enterprise sous-traitante
            $table->string('speaker_3')->nullable(); // Enterprise sous-traitante
            $table->string('location')->nullable(); // Emplacement prévu
            $table->time('start_time')->nullable(); // Début d'intervention
            $table->time('end_time')->nullable(); // Fin d'intervention prévue
            $table->string('operation_description')->nullable(); // Description
            $table->string('operative_mode_number')->nullable(); // N° mode opératoire
            $table->text('interference_risks')->nullable(); // Risques d'interférence
            $table->text('work_nature')->nullable(); // Nature du travail
            $table->text('risk_nature')->nullable(); // Nature des risques
            $table->text('training_certifications')->nullable(); // Formations / Habilitations
            $table->boolean('pir_pirl')->default(false); // Checkbox for PIR/PIRL
            $table->boolean('technical_document')->default(false); // Document Technique Amiante
            $table->boolean('crane')->default(false); // Grue
            $table->boolean('work_start_declaration')->default(false); // Déclaration d'intention de commencement de travaux
            $table->boolean('scaffolding')->default(false); // Échafaudage
            $table->boolean('network_plans')->default(false); // Plans de réseaux
            $table->boolean('degassing_certificate')->default(false); // Certificat de dégazage
            $table->string('fire_permit')->nullable(); // Permis de feu
            $table->string('specific_permit')->nullable(); // Permis spécifique
            $table->string('other_permit')->nullable(); // Autres (préciser)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

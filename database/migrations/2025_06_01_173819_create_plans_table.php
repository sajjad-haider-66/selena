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
            $table->date('work_date')->nullable(); // Work date (e.g., 2003-10-28)
            $table->json('company_name_detail')->nullable(); // External company 1
            $table->string('location')->nullable(); // Emplacement prévu
            $table->time('start_time')->nullable(); // Début d'intervention
            $table->time('end_time')->nullable(); // Fin d'intervention prévue
            $table->time('depotage_time')->nullable(); // Depotage time (e.g., 00:22)
            $table->string('presence_zone')->nullable(); // Presence zone
            $table->text('other_works')->nullable(); // Other works
            $table->text('description')->nullable(); // Description (renamed for consistency with form)
            $table->string('operative_mode_number')->nullable(); // N° mode opératoire
            $table->text('work_nature')->nullable(); // Nature du travail (stores travail array as JSON)
            $table->text('work_nature_other')->nullable(); // travail_autre
            $table->text('risk_nature')->nullable(); // Nature des risques (stores risques array as JSON)
            $table->text('risk_nature_other')->nullable(); // risques_autre
            $table->text('training_certifications')->nullable(); // Formations / Habilitations (stores formations array as JSON)
            $table->text('training_certifications_other')->nullable(); // formations_autre
            $table->json('avant_entreprise')->nullable(); // avant_entreprise_1
            $table->date('before_date')->nullable(); // avant_date
            $table->time('before_time')->nullable(); // avant_heure
            $table->string('before_responsible_name')->nullable(); // avant_responsable_nom
            $table->boolean('work_not_completed')->default(false); // apres_travail_non_termine
            $table->date('new_authorization_date')->nullable(); // apres_nouvelle_autorisation
            $table->json('company_nom_date')->nullable(); // apres_entreprise_1_nom
            $table->date('after_responsible_date')->nullable(); // apres_responsable_date
            $table->time('after_responsible_time')->nullable(); // apres_responsable_heure
            $table->string('after_responsible_name')->nullable(); // apres_responsable_nom
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
            $table->boolean('work_completed')->default(false);
            $table->boolean('station_normal')->default(false); // Station normale
            $table->boolean('site_clean_safe')->default(false);
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

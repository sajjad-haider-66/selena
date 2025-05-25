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
        Schema::create('audits', function (Blueprint $table) {
            $table->id('id');
            $table->date('date');
            $table->string('site');
            $table->string('auditor');
            $table->string('intervenant');
            $table->string('themes_comments')->nullable();
            $table->string('mission_score')->nullable();
            $table->text('mission_comments')->nullable();
            $table->string('risks_score')->nullable();
            $table->text('risks_comments')->nullable();
            $table->string('trainings_score')->nullable();
            $table->text('trainings_comments')->nullable();
            $table->string('authorizations_score')->nullable();
            $table->text('authorizations_comments')->nullable();
            $table->string('env_risks_score')->nullable();
            $table->text('env_risks_comments')->nullable();
            $table->string('access_score')->nullable();
            $table->text('access_comments')->nullable();
            $table->string('safety_score')->nullable();
            $table->text('safety_comments')->nullable();
            $table->string('mase_score')->nullable();
            $table->text('mase_comments')->nullable();
            $table->string('prevention_score')->nullable();
            $table->text('prevention_comments')->nullable();
            $table->string('client_expectations_score')->nullable();
            $table->text('client_expectations_comments')->nullable();
            $table->string('feedback_score')->nullable();
            $table->text('feedback_comments')->nullable();
            $table->string('last_causerie_score')->nullable();
            $table->text('last_causerie_comments')->nullable();
            $table->string('sse_score')->nullable();
            $table->text('sse_comments')->nullable();
            $table->json('actions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};

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
        Schema::create('actions', function (Blueprint $table) {
            $table->id('action_id');
            $table->enum('origin', [
                'Audit MASE', 'Revue Direction', 'Vérifications Périodiques', 'Document Unique',
                'Audits Terrains', 'Accident', 'Incident', 'Animations SSE', 'Demandes Client',
                'Communication', 'Veille Règlementaire', 'Comité SSE'
            ]);
            $table->text('description');
            $table->enum('action_type', ['Immediate', 'Corrective', 'Preventive']);
            $table->unsignedBigInteger('pilot_id');
            $table->date('due_date');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('verifier_id')->nullable();
            $table->date('verified_date')->nullable();
            $table->integer('progress')->default(0);
            $table->enum('efficiency', ['O', 'N'])->nullable();
            $table->text('comment')->nullable();
            $table->enum('status', ['Not Started', 'In Progress', 'Completed'])->default('Not Started');
            $table->timestamps();
            
            // $table->foreign('pilot_id')->references('user_id')->on('users')->onDelete('cascade');
            // $table->foreign('verifier_id')->references('user_id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};

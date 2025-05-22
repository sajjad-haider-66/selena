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
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->date('date');
            $table->unsignedBigInteger('site_id');
            $table->enum('event_type', ['Dangerous Situation', 'Near Miss', 'Incident', 'Accident', 'Occupational Illness']);
            $table->unsignedBigInteger('emitter_id');
            $table->json('categories')->nullable();
            $table->text('description');
            $table->text('risks')->nullable();
            $table->json('media')->nullable();
            $table->json('risk_analysis')->nullable();
            $table->json('risk_cotation')->nullable();
            $table->text('propositions')->nullable();
            $table->json('measure_types')->nullable();
            $table->enum('status', ['Reported', 'Validated'])->default('Reported');
            $table->timestamps();
            
            // $table->foreign('site_id')->references('site_id')->on('sites')->onDelete('cascade');
            // $table->foreign('emitter_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

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
           $table->id();
            $table->date('date');
            $table->string('lieu');
            $table->string('type')->nullable(); // Dangerous situation, Near miss, Work accident, Occupational illness
            $table->string('emetteur')->nullable();
            $table->boolean('securite')->default(false);
            $table->boolean('sante')->default(false);
            $table->boolean('environnement')->default(false);
            $table->boolean('rse')->default(false);
            $table->text('circonstances')->nullable();
            $table->text('risques')->nullable();
            $table->json('analyse')->nullable(); // Array of checked risk factors
            $table->integer('cotation')->nullable();
            $table->string('frequence')->nullable(); // 1, 2, 3, 4
            $table->string('gravite')->nullable(); // 1, 2, 3, 4
            $table->json('propositions')->nullable(); // Array of propositions
            $table->json('mesures')->nullable(); // Array of measures
            $table->json('actions')->nullable(); // Array of actions with responsible, deadline, type
            $table->json('attachments')->nullable(); // Photos or videos
            $table->string('status')->default('pending'); // pending, completed, processing
            $table->boolean('validated')->default(false);
            $table->timestamps();
            
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

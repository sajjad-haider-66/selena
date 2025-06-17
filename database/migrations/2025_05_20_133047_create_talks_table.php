<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('talks', function (Blueprint $table) {
            $table->id('id');
            $table->foreignIdFor(User::class, 'created_by');
            $table->date('date');
            $table->string('lieu');
            $table->string('theme');
            $table->json('animateur');
            $table->string('signature')->nullable();
            $table->boolean('security')->default(false);
            $table->boolean('health')->default(false);
            $table->boolean('environment')->default(false);
            $table->boolean('rse')->default(false);
            $table->text('points')->nullable();
            $table->text('commentaires')->nullable();
            $table->text('path')->nullable();
            $table->json('participants')->nullable(); // Array of participants with name and signature
            $table->json('actions')->nullable(); // Array of actions with type
            $table->json('materials')->nullable(); // Uploaded materials or recordings
            $table->json('feedback')->nullable(); // Feedback or concerns from users
            $table->string('status')->default('scheduled'); // scheduled, completed, archived
            $table->text('notes')->nullable(); // Additional notes for archiving
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talks');
    }
};

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
            $table->id();
           $table->date('date');
            $table->string('lieu');
            $table->string('auditeur');
            $table->string('intervenant');
            $table->json('responses')->nullable(); // Array of responses with notes and comments
            $table->string('culture_sse')->nullable(); // SSE culture score (++, +, =/-, -, --)
            $table->integer('qser_score')->nullable(); // Added QSER score
            $table->json('actions')->nullable(); // Array of actions
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

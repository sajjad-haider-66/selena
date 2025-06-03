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
        Schema::create('readiness_forms', function (Blueprint $table) {
            $table->id('id');
            $table->date('date');
            $table->string('site_name');
            $table->string('company_name')->nullable();
            $table->string('permit_number')->nullable();
            $table->string('commentaires')->nullable();
            $table->string('nom')->nullable();
            $table->string('entreprise')->nullable();
            $table->string('signature')->nullable();
            $table->string('form_heading')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->json('checklist_data')->nullable();
            $table->float('readiness_rate')->nullable();
            $table->enum('status', ['Green', 'Blocked'])->default('Blocked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readiness_forms');
    }
};

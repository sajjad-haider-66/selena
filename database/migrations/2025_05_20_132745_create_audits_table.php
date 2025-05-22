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
            $table->id('audit_id');
            $table->date('date');
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('auditor_id');
            $table->unsignedBigInteger('intervenant_id')->nullable();
            $table->json('themes_data')->nullable();
            $table->json('evaluation')->nullable();
            $table->enum('culture_sse_rating', ['++', '+', '=+/-', '-', '--'])->nullable();
            $table->enum('status', ['Draft', 'Completed'])->default('Draft');
            $table->timestamps();
            
            // $table->foreign('site_id')->references('site_id')->on('sites')->onDelete('cascade');
            // $table->foreign('auditor_id')->references('user_id')->on('users')->onDelete('cascade');
            // $table->foreign('intervenant_id')->references('user_id')->on('users')->onDelete('set null');
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

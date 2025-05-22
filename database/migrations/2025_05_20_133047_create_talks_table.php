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
        Schema::create('talks', function (Blueprint $table) {
            $table->id('talk_id');
            $table->date('date');
            $table->unsignedBigInteger('site_id');
            $table->string('theme');
            $table->unsignedBigInteger('animator_id');
            $table->json('categories')->nullable();
            $table->text('description')->nullable();
            $table->text('feedback')->nullable();
            $table->json('materials')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamps();
            
            // $table->foreign('site_id')->references('site_id')->on('sites')->onDelete('cascade');
            // $table->foreign('animator_id')->references('user_id')->on('users')->onDelete('cascade');
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

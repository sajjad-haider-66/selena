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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->unsignedBigInteger('talk_id');
            $table->unsignedBigInteger('user_id');
            $table->string('signature')->nullable();
            $table->timestamp('marked_at')->nullable();
            $table->timestamps();
            
            // $table->foreign('talk_id')->references('talk_id')->on('talks')->onDelete('cascade');
            // $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};

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
            $table->id();
           $table->string('origin');
            $table->integer('origin_id')->nullable();
            $table->text('description');
            $table->dateTime('issued_date')->nullable();
            $table->enum('type', ['Immediate', 'Corrective', 'Preventive'])->default('Preventive');
            $table->Integer('verifier_id')->nullable();
            $table->date('due_date');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('verified_date')->nullable();
            $table->integer('progress_rate')->default(0);
            $table->enum('efficiency', ['O', 'N'])->nullable();
            $table->text('comments')->nullable();
            $table->enum('status', ['Not Started', 'In Progress', 'Completed'])->default('Not Started');
            $table->string('pilot_id')->nullable();
             $table->json('json_data')->nullable();
            $table->timestamps();
            
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

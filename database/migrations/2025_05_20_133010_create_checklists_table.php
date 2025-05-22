<?php

use App\Models\ReadinessForm;
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
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ReadinessForm::class);
            $table->string('question_number')->nullable();
            $table->text('question');
            $table->enum('answer', ['Yes', 'No', 'N/A'])->nullable();
            $table->integer('score')->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklists');
    }
};

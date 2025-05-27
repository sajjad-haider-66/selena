<?php

use App\Models\TalkAnimation;
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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(TalkAnimation::class)->nullable();
            $table->date('date')->default(now()->toDateString());
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->unique(['user_id', 'date']);
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

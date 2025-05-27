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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'to_user_id ');
            $table->foreignIdFor(User::class, 'from_user_id ')->nullable();
            $table->string('action');
            $table->string('node_type')->nullable();
            $table->string('node_id')->nullable();
            $table->string('node_url')->nullable();
            $table->text('message')->nullable();
            $table->text('image')->nullable();
            $table->string('notifiable_text')->nullable();
            $table->enum('seen', [0,1])->default(0);
            $table->enum('read', [0,1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

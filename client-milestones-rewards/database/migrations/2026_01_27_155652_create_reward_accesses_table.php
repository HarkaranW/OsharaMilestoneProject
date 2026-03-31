<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reward_accesses', function (Blueprint $table) {
            $table->id();

            // MVP client identifier (email is easiest for now)
            $table->string('client_email');
            $table->string('client_name')->nullable()->after('client_email');


            $table->foreignId('milestone_id')->constrained('milestones')->cascadeOnDelete();
            $table->foreignId('reward_id')->constrained('rewards')->cascadeOnDelete();

            // secure non-guessable token for the link
            $table->string('token')->unique();

            // status + logging
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('opened_at')->nullable();  // when client opened link
            $table->timestamp('claimed_at')->nullable(); // when reward claimed
            $table->boolean('used')->default(false);

            $table->timestamps();

            // prevents awarding same milestone twice per client
            $table->unique(['client_email', 'milestone_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reward_accesses');
    }
};


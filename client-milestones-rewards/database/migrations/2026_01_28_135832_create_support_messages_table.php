<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_messages', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('email', 255);
            $table->string('subject', 150);
            $table->text('message');

            // Optional: link message to a reward link (nice for “unique” support)
            $table->unsignedBigInteger('reward_access_id')->nullable();
            $table->string('reward_token', 80)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_messages');
    }
};

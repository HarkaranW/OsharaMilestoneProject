<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();

            // one settings row per admin user
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            // Defaults
            $table->unsignedInteger('default_expiry_days')->default(7); // 7 days
            $table->string('reward_assignment')->default('random'); // random | milestone

            // Notifications
            $table->boolean('notif_claimed')->default(true);
            $table->boolean('notif_opened')->default(true);
            $table->boolean('notif_expired')->default(false);
            $table->boolean('notif_weekly')->default(true);

            // Security
            $table->boolean('enforce_one_time')->default(true);
            $table->boolean('prevent_multi_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_settings');
    }
};
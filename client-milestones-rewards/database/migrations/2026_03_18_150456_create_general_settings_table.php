<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();

            // Branding
            $table->string('app_name')->default('Bizlyt');
            $table->string('support_email')->nullable();
            $table->string('accent_color')->default('#3b82f6');
            $table->string('logo_light')->nullable();
            $table->string('logo_dark')->nullable();
            $table->string('favicon')->nullable();

            // Email / SMTP
            $table->string('mail_driver')->default('smtp');
            $table->string('mail_host')->nullable();
            $table->unsignedSmallInteger('mail_port')->default(587);
            $table->string('mail_encryption')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_from_name')->nullable();
            $table->string('mail_from_address')->nullable();

            // Reward defaults
            $table->unsignedTinyInteger('default_expiry')->default(7);
            $table->string('reward_assignment')->default('random');
            $table->unsignedTinyInteger('max_active_links')->default(1);
            $table->unsignedInteger('points_per_milestone')->default(100);
            $table->boolean('notify_claimed')->default(true);
            $table->boolean('notify_opened')->default(true);
            $table->boolean('notify_expired')->default(false);
            $table->boolean('notify_weekly')->default(true);

            // Security
            $table->boolean('enforce_one_time')->default(true);
            $table->boolean('prevent_multiple_links')->default(true);
            $table->boolean('require_email_verify')->default(false);
            $table->boolean('require_2fa')->default(false);
            $table->boolean('session_timeout_enabled')->default(false);
            $table->unsignedSmallInteger('session_timeout_minutes')->default(30);
            $table->unsignedTinyInteger('max_login_attempts')->default(5);
            $table->text('allowed_ips')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
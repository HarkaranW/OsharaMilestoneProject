<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = 'general_settings';

    protected $fillable = [
        // Branding
        'app_name',
        'support_email',
        'accent_color',
        'logo_light',
        'logo_dark',
        'favicon',

        // Email / SMTP
        'mail_driver',
        'mail_host',
        'mail_port',
        'mail_encryption',
        'mail_username',
        'mail_password',
        'mail_from_name',
        'mail_from_address',

        // Reward defaults
        'default_expiry',
        'reward_assignment',
        'max_active_links',
        'points_per_milestone',
        'notify_claimed',
        'notify_opened',
        'notify_expired',
        'notify_weekly',

        // Security
        'enforce_one_time',
        'prevent_multiple_links',
        'require_email_verify',
        'require_2fa',
        'session_timeout_enabled',
        'session_timeout_minutes',
        'max_login_attempts',
        'allowed_ips',
    ];

    protected $casts = [
        'notify_claimed'           => 'boolean',
        'notify_opened'            => 'boolean',
        'notify_expired'           => 'boolean',
        'notify_weekly'            => 'boolean',
        'enforce_one_time'         => 'boolean',
        'prevent_multiple_links'   => 'boolean',
        'require_email_verify'     => 'boolean',
        'require_2fa'              => 'boolean',
        'session_timeout_enabled'  => 'boolean',
    ];

    /**
     * Always work with a single row — fetch or create it.
     */
    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1], []);
    }
}
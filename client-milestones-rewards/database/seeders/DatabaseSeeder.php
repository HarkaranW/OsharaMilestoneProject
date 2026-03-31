<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Reward;
use App\Models\Milestone;
use App\Models\RewardAccess;

use Illuminate\Support\Facades\Mail;
use App\Mail\RewardUnlocked;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Rewards
        Reward::insert([
            [
                'title' => 'Free SEO or Technical Audit',
                'description' => 'A full review of your SEO and technical setup with clear priorities.',
                'instructions' => "Claim your reward\nWe’ll ask for your website + goals\nYou receive the audit report",
                'one_time' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Free Optimization or Improvement',
                'description' => 'We implement one high-impact improvement (SEO, speed, or structure).',
                'instructions' => "Claim your reward\nWe’ll confirm the best improvement\nWe implement and share the results",
                'one_time' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Premium Report (SEO, Ads, Performance)',
                'description' => 'A premium report with insights, issues, and opportunities.',
                'instructions' => "Claim your reward\nChoose report type (SEO/Ads/Performance)\nWe deliver your report by email",
                'one_time' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Strategic Consulting Call',
                'description' => 'A strategy call with our team to plan next steps and priorities.',
                'instructions' => "Claim your reward\nWe send booking options\nJoin the call and get your action plan",
                'one_time' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Exclusive Resource (Guide, Checklist, Template)',
                'description' => 'Access to an exclusive Oshara resource to help you grow faster.',
                'instructions' => "Claim your reward\nWe send you the resource link\nUse it anytime (keep it forever)",
                'one_time' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Milestones
        $milestone3 = Milestone::create([
            'name' => '3 Months with Oshara',
            'type' => 'time',
            'trigger_condition' => '3 months',
            'reward_id' => null,
        ]);

        $milestone6 = Milestone::create([
            'name' => '6 Months with Oshara',
            'type' => 'time',
            'trigger_condition' => '6 months',
            'reward_id' => null,
        ]);

        $milestone12 = Milestone::create([
            'name' => '12 Months with Oshara',
            'type' => 'time',
            'trigger_condition' => '12 months',
            'reward_id' => null,
        ]);

        // Random reward helper
        $getRandomRewardId = function () {
            return Reward::inRandomOrder()->value('id');
        };

        /**
         * Create test clients (RewardAccess records)
         * Then "send email" (MAIL_MAILER=log recommended)
         */
        $clients = [
            [
                'client_name' => 'Jamal',
                'client_email' => 'test2@client.com',
                'milestone_id' => $milestone6->id,
                // changed from now() -> future so it’s not instantly expired
                'expires_at' => now()->addDays(7),
            ],
            [
                'client_name' => 'Alex',
                'client_email' => 'test3@client.com',
                'milestone_id' => $milestone12->id,
                'expires_at' => now(),
            ],
        ];

        foreach ($clients as $c) {

            $access = RewardAccess::create([
                'client_name' => $c['client_name'],
                'client_email' => $c['client_email'],
                'milestone_id' => $c['milestone_id'],
                'reward_id' => $getRandomRewardId(),
                'token' => Str::random(40),
                'expires_at' => $c['expires_at'],

                'used' => false,
                'opened_at' => null,
                'claimed_at' => null,
            ]);

            // Load relations so the email template can use $access->milestone and $access->reward
            $access->load(['milestone', 'reward']);

            // Send email (log mailer is easiest for testing)
            Mail::to($access->client_email)->send(new RewardUnlocked($access));
        }
    }
}

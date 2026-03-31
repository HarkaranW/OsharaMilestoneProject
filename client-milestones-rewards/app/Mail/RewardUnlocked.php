<?php

namespace App\Mail;

use App\Models\RewardAccess;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RewardUnlocked extends Mailable
{
    use Queueable, SerializesModels;

    public RewardAccess $access;
    public string $link;

    public function __construct(RewardAccess $access)
    {
        $this->access = $access;
        $this->link = url('/reward/' . $access->token);
    }

    public function build()
    {
        return $this->subject('🎉 You unlocked a milestone reward')
            ->view('emails.reward-unlocked');
    }
}

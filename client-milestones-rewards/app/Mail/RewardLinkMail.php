<?php

namespace App\Mail;

use App\Models\RewardAccess;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RewardLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public RewardAccess $access, public string $link) {}

    public function build()
    {
        return $this
            ->subject('🎉 Your Oshara milestone reward is ready')
            ->view('emails.reward-link');
    }
}
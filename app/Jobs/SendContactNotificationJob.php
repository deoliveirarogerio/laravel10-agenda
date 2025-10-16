<?php
namespace App\Jobs;

use App\Models\Contact;
use App\Mail\ContactRegistered;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendContactNotificationJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function handle()
    {
        $to = env('NOTIFICATION_MAIL');
        if (!$to) return;
        Mail::to($to)->send(new ContactRegistered($this->contact));
    }
}

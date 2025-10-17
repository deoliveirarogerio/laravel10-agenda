<?php

namespace App\Jobs;

use App\Mail\ContactRegistered;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Contact $contact;
    public string $recipient;

    public function __construct(Contact $contact, string $recipient)
    {
        $this->contact = $contact;
        $this->recipient = $recipient;

        // $this->onQueue('back_emails');
    }

    public function handle(): void
    {
        if (!$this->contact || !$this->contact->exists) {
            return;
        }

        /** @var Mailable $mailable */
        $mailable = new ContactRegistered($this->contact);


        Mail::to($this->recipient)->queue($mailable->onQueue('back_emails'));

        //Mail::to($this->recipient)->send($mailable);
    }
}

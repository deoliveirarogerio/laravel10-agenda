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

    /**
     * Atenção: SerializesModels armazena uma referência ao ID do modelo,
     * recarregando-o do banco no momento do handle().
     */
    public function __construct(Contact $contact, string $recipient)
    {
        $this->contact = $contact;
        $this->recipient = $recipient;

        // Se quiser garantir a fila deste job aqui (opcional):
        // $this->onQueue('back_emails');
    }

    public function handle(): void
    {
        // Se o registro foi removido antes do processamento, evite exception
        if (!$this->contact || !$this->contact->exists) {
            return;
        }

        // Enviar o mailable
        /** @var Mailable $mailable */
        $mailable = new ContactRegistered($this->contact);

        // Opcional: definir uma fila específica para o envio do mailable
        // Mail::to($this->recipient)->queue($mailable->onQueue('back_emails'));

        // Como o próprio job já está na fila, send() é suficiente (a execução já é assíncrona)
        Mail::to($this->recipient)->send($mailable);
    }
}

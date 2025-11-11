<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionInscripcion extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;
    public $titulo;

    /**
     * Create a new message instance.
     */
    public function __construct($titulo, $mensaje)
    {
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
    }
    
    /**
     * Build the message.
     */

    public function build()
    {
        return $this->subject($this->titulo)
                    ->view('email.notificacion')
                    ->with(['mensaje' => $this->mensaje]);
    }

    /**
     * Get the message envelope.
     */
    /*public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificacion Inscripcion',
        );
    }*/

    /**
     * Get the message content definition.
     */
    /*public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }*/

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentoSubmetido extends Mailable
{
    use Queueable, SerializesModels;

    public $cadastro;
    public $anexo;

    public function __construct($cadastro, $anexo)
    {
        $this->cadastro = $cadastro;
        $this->anexo = $anexo;
    }

    public function build()
    {
        return $this->subject('Novo Documento Submetido')
                    ->view('emails.documento-submetido')
                    ->with([
                        'nome' => $this->cadastro->nome,
                        'email' => $this->cadastro->email,
                        'nomeAnexo' => $this->anexo->ficheiro
                    ]);
    }
}

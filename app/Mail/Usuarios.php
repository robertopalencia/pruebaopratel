<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Usuarios extends Mailable
{
    use Queueable, SerializesModels;
    public $usuarios;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuarios)
    {
        $this->usuarios = $usuarios;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.usuarios');
    }
}

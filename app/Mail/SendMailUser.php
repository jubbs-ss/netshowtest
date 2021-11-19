<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class SendMailUser extends Mailable
{
    use Queueable, SerializesModels;
    private $email;
    private $nome;
    private $msg;
    private $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$nome,$msg,$file)
    {
        $this->email = $email;
        $this->nome = $nome;
        $this->msg = $msg;
        $this->file = $file;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('AVISO DO TESTE TÉCNICO PHP - BACK-END DEVELOPER');
        $this->to($this->email, $this->nome);
        $this->attach($this->file);

        return $this->markdown('mail.SendMailUser',['msg' => $this->msg]);


    }
}

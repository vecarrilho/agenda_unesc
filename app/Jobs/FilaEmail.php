<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class FilaEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $dataEmail = array('data'=>$this->, 'hora'=>'13:30', 'bloco'=>'XXIC');
        Mail::send('emails.email', $this->details, function($message){
            //SUBSTITUIR PELO EMAIL DO ACADEMICO
            $message->to($this->details->email, 'Artisan')
                    ->subject('Agendamento de prova');
            $message->from('noreply.agendaprova@unesc.net');
        });
        $email = new SendMail($this->details);
        Mail::to('vecarrilho@unesc.net')->send($email);
    }
}

<?php

namespace App\Listeners;

use App\Events\NovaSerie;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EnviarEmailNovaSerieCadastrada
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NovaSerie  $event
     * @return void
     */
    public function handle(NovaSerie $event)
    {
        $nomeSerie = $event->nomeSerie;
        $qtdTemporadas = $event->qtdTemporadas;
        $qtdEpisodios = $event->qtdEpisodios;

        $users = User::all();
        foreach ($users as $indice => $user)
        {
            $multiplicador = $indice + 1;
            $email =  new \App\Mail\NovaSerie(
                $nomeSerie,
                $qtdTemporadas,
                $qtdEpisodios,
            );
            $email->subject = 'Nova Série Adicionada';
            $quando = now()->addSecond($multiplicador * 10);
            \Illuminate\Support\Facades\Mail::to($user)->later(
                $quando,
                $email
            );

        }
    }
}

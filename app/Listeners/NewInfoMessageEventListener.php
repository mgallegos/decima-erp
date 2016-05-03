<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Log\Writer;
use Illuminate\Foundation\Application;

class NewInfoMessageEventListener implements ShouldQueue
{
  /**
   * Laravel Writer (Log)
   *
   * @var Illuminate\Log\Writer
   *
   */
  protected $Log;

  /**
   * Raven
   *
   * @var App\Kwaai\System\Services\Sentry\RavenLogHandler
   *
   */
  protected $Raven;

  /**
   * The Laravel application.
   *
   * @var \Illuminate\Foundation\Application
   */
  protected $App;


  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(Writer $Log, Application $App)
  {
    $this->Log = $Log;

    $this->App = $App;
  }

  /**
   * Handle the event.
   *
   * @param  $Event
   * @return void
   */
  public function handle($Event)
  {
    $this->Log->info($Event->data['message'], $Event->data['context']);

    if(!empty(env('RAVEN_DSN')))
    {
      // $this->Raven->log('info', $Event->data['message']);
      // $this->App['raven.handler']->log('info', $Event->data['message'], $Event->data['context']);
    }
  }
}

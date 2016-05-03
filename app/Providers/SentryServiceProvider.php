<?php

namespace App\Providers;

use InvalidArgumentException;
use Raven_Client;
use Raven_ErrorHandler;
use App\Kwaai\System\Services\Sentry\RavenLogHandler;
use Illuminate\Support\ServiceProvider;

class SentryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      return;
      
      $app = $this->app;

      if(empty(env('RAVEN_DSN')))
      {
        return;
      }

      $this->app->bind('raven.client', function ($app)
      {
          $config = $app['config']->get('services.raven', []);

          $dsn = env('RAVEN_DSN') ?: $app['config']->get('services.raven.dsn');

          if ( ! $dsn)
          {
              // throw new InvalidArgumentException('Raven DSN not configured');
              return;
          }

          // Use async by default.
          if (empty($config['curl_method']))
          {
              $config['curl_method'] = 'async';
          }

          return new Raven_Client($dsn, array_except($config, ['dsn']));
      });

      $this->app->bind('raven.handler', function ($app)
      {
          // $app['log']->info('Entre en raven.handler 1');

          $level = $app['config']->get('services.raven.level', 'debug');

          // $app['log']->info('Entre en raven.handler 2');

          return new RavenLogHandler($app['raven.client'], $app, $level);
      });

      // Register the fatal error handler.
      register_shutdown_function(function () use ($app)
      {
          if (isset($app['raven.client']))
          {
              (new Raven_ErrorHandler($app['raven.client']))->registerShutdownFunction();
          }
      });
    }
}

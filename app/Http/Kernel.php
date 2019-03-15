<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        // \Clockwork\Support\Laravel\ClockworkMiddleware::class,
        // \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        // 'auth' => \App\Http\Middleware\CheckLoggedUser::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'csrf' => \App\Http\Middleware\VerifyCsrfToken::class,
    		'check.browser' => \App\Http\Middleware\CheckBrowser::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'cors' => \App\Http\Middleware\Cors::class,
        'check.first.time.access' => \App\Http\Middleware\CheckFirstTimeAccess::class,
    		'check.access' => \App\Http\Middleware\CheckAccess::class,
    		'check.accounting.setup' => \Mgallegos\DecimaAccounting\Accounting\Middleware\CheckAccountingSetup::class
    ];
}

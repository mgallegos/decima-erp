<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Session\SessionManager;
use Illuminate\Routing\UrlGenerator;

class CheckLoggedUser
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
  	 * Session
  	 *
  	 * @var Illuminate\Session\SessionManager
  	 *
  	 */
  	protected $Session;

    /**
  	 * The URL generator instance
  	 *
  	 * @var \Illuminate\Routing\UrlGenerator
  	 *
  	 */
  	protected $Url;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth, SessionManager $Session, UrlGenerator $Url)
    {
      $this->auth = $auth;

      $this->Session = $Session;

      $this->Url = $Url;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(!$this->Session->has('loggedUser'))
  		{
  			if ($this->auth->check())
        {
          $this->Session->put('loggedUser', json_encode($this->auth->user()->toArray()));

          return $next($request);
        }

  			if ($request->ajax())
  			{
  				return response('Unauthorized.', 401);
  			}
  			else
  			{
  				if(str_replace($this->Url->to('/'), '', $this->Url->current()) != '/login')
  				{
  					return redirect()->guest('login');
  				}
  			}
  		}

      return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Session\SessionManager;

class RedirectIfAuthenticated
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
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth, SessionManager $Session)
    {
      $this->auth = $auth;

      $this->Session = $Session;
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
      if($this->Session->has('loggedUser'))
      {
        return redirect('/dashboard');
      }

      if ($this->auth->check())
      {
        $this->Session->put('loggedUser', json_encode($this->auth->user()->toArray()));

        return redirect('/dashboard');
      }

      // if ($this->auth->check())
      // {
      //   if(!$this->Session->has('loggedUser'))
    	// 	{
      //     $this->Session->put('loggedUser', json_encode($this->auth->user()->toArray()));
    	// 	}
      //
      //   return redirect('/dashboard');
      // }

      return $next($request);
    }
}

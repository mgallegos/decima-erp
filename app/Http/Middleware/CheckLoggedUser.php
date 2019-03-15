<?php namespace App\Http\Middleware;

use Closure;
use Session;
use URL;

class CheckLoggedUser {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(!Session::has('loggedUser'))
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				if(str_replace(URL::to('/'), '', URL::current()) != '/login')
				{
					return redirect()->guest('login');
				}
			}
		}

		return $next($request);
	}

}

<?php namespace App\Http\Middleware;

use Closure;
use AppManager;
use AuthManager;
use UserManager;
use Exception;


class CheckAccess {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($request->isMethod('get') && !AppManager::isUserClearToAccessApp())
		{
			if(AuthManager::isUserAdmin() && UserManager::getCountUserOrganizations() == 0)
			{
				return $next($request);
			}

			throw new Exception('User does not have permission to access this appplication');
		}

		return $next($request);
	}

}

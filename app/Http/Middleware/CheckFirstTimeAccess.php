<?php namespace App\Http\Middleware;

use Closure;
use AppManager;
use AuthManager;
use UserManager;
use Illuminate\Http\RedirectResponse;

class CheckFirstTimeAccess {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if($request->isMethod('get') && AuthManager::isUserDefaultRoot() && !AppManager::isInitialSetupPage())
		{
			return new RedirectResponse(AppManager::getInitialSetupPageUrl());
		}

		if($request->isMethod('get') && !AuthManager::isUserDefaultRoot() && AuthManager::isUserAdmin() && UserManager::getCountUserOrganizations() == 0 && !AppManager::isOrganizationManagementApp())
		{
			return new RedirectResponse(AppManager::getNewOrganizationManagementAppUrl());
		}

		return $next($request);
	}
}

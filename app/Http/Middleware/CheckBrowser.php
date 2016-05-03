<?php namespace App\Http\Middleware;

use Closure;
use Event;
use AppManager;
use Agent;
use Lang;
use Redirect;
use Illuminate\Http\RedirectResponse;
use App\Events\OnInvalidBrowser;

class CheckBrowser {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!Agent::isSafari() && !Agent::isIE() && !Agent::isFirefox() && Agent::browser() != 'Chrome')
		{
			// Event::fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User tried to access the aplication usign an unsupported browser', 'context' => array('extra' => ''))));
			return Redirect::to(AppManager::getErrorPageUrl())->withError(Lang::get('validation.invalidBrowser'));
		}
		else
		{
			if(Agent::isSafari() && intval(Agent::version(Agent::browser())) < 7 || Agent::isIE() && intval(Agent::version(Agent::browser())) < 10)
				{
					// Event::fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User tried to access the aplication usign an unsupported browser', 'context' => array('extra' => ''))));
					return Redirect::to(AppManager::getErrorPageUrl())->withError(Lang::get('validation.invalidBrowser'));
				}
		}

		return $next($request);
	}

}

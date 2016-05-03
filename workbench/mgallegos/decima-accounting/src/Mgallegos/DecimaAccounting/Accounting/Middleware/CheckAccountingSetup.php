<?php
/**
 * @file
 * Check Accounting Setup Middleware.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Middleware;

use Closure;
use Mgallegos\DecimaAccounting\Accounting\Services\SettingManagement\SettingManagementInterface;

class CheckAccountingSetup {

	/**
	 * Setting Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\SettingManagement\SettingManagementInterface
	 *
	 */
	protected $SettingManagerService;

	/**
	 * Create a new filter instance.
	 *
	 * @param  SettingManagementInterface $SettingManagerService
	 * @return void
	 */
	public function __construct(SettingManagementInterface $SettingManagerService)
	{
		$this->SettingManagerService = $SettingManagerService;
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
		if(!$this->SettingManagerService->isAccountingSetup())
		{
			return redirect('accounting/setup/initial-accounting-setup');
		}

		return $next($request);
	}

}

<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\System\Services;

use App\Kwaai\Helpers\Gravatar;

use Carbon\Carbon;

use App\Kwaai\System\Services\SettingManagement\SettingManager;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 *
	 * @return void
	 */
	public function register()
	{
  	$this->registerSettingManagementInterface();
	}

	/**
	* Register a Setting interface instance.
	*
	* @return void
	*/
	protected function registerSettingManagementInterface()
	{
		$this->app->bind('App\Kwaai\System\Services\SettingManagement\SettingManagementInterface', function($app)
		{
			return new \App\Kwaai\System\Services\SettingManagement\SettingManager(
				$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
				$app->make('App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface'),
				$app->make('App\Kwaai\Security\Repositories\Journal\JournalInterface'),
				new	\Mgallegos\LaravelJqgrid\Encoders\JqGridJsonEncoder($app->make('excel')),
				$app->make('App\Kwaai\System\Repositories\SlvSetting\SlvSettingInterface'),
				new Carbon(),
				$app['db'],
				$app['translator'],
				$app['config'],
				$app['cache']
			);
		});
	}
}

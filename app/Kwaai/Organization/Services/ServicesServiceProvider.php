<?php
/**
 * @file
 * Organization Services Service Provider
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Organization\Services;

use App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManager;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerOrganizationManagementInterface();
	}


	protected function registerOrganizationManagementInterface()
	{
		$this->app->bind('App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManagementInterface', function($app)
		{
			return new OrganizationManager(
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app->make('App\Kwaai\Security\Services\UserManagement\UserManagementInterface'),
					$app->make('App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface'),
					new	\Mgallegos\LaravelJqgrid\Encoders\JqGridJsonEncoder($app->make('excel')),
					new	\App\Kwaai\Organization\Repositories\Organization\EloquentOrganizationGridRepository(
						$app['db'],
						$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface')
					),
					$app->make('App\Kwaai\System\Repositories\Country\CountryInterface'),
					$app->make('App\Kwaai\System\Repositories\Currency\CurrencyInterface'),
					$app->make('App\Kwaai\Organization\Repositories\Organization\OrganizationInterface'),
					$app->make('App\Kwaai\Security\Repositories\User\UserInterface'),
					$app->make('App\Kwaai\Security\Repositories\Role\RoleInterface'),
					$app->make('App\Kwaai\Security\Repositories\Journal\JournalInterface'),
					$app->make('NewOrganizationTriggerInterface'),
					$app['db'],
					$app['translator'],
					$app['log'],
					$app['events'],
					$app['cache'],
					$app['session']
			);
		});
	}
}

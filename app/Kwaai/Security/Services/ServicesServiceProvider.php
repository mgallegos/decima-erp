<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Services;

use App\Kwaai\Helpers\Gravatar;

use Carbon\Carbon;

use App\Kwaai\Security\Services\JournalManagement\JournalManager;

use App\Kwaai\Security\Services\AppManagement\AppManager;

use App\Kwaai\Security\Services\UserManagement\UserManager;

use App\Kwaai\Security\Services\AuthenticationManagement\LaravelAuthenticationManager;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerAppJournalConfiguration();

		$this->registerAuthenticationInterface();

  	$this->registerJournalManagementInterface();

		$this->registerUserManagementInterface();

		$this->registerAppManagementInterface();
	}

	/**
	* Register app journal configuration.
	*
	* @return void
	*/
	protected function registerAppJournalConfiguration()
	{
		$this->app->bind('AppJournalConfigurations', function($app)
		{
			return $app['config']->get('journal');
		});
	}

	/**
	 * Register the authenticator instance.
	 *
	 * @return void
	 */
	protected function registerAuthenticationInterface()
	{
		$this->app->bind('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface', function($app)
		{
			return new LaravelAuthenticationManager(
					$app->make('App\Kwaai\Organization\Repositories\Organization\OrganizationInterface'),
					$app->make('App\Kwaai\Security\Repositories\User\UserInterface'),
					$app->make('App\Kwaai\System\Repositories\Currency\CurrencyInterface'),
					$app->make('App\Kwaai\System\Repositories\Country\CountryInterface'),
					$app['auth'],
					$app['translator'],
					$app['cache'],
					$app['url'],
					$app['log'],
					$app['redirect'],
					$app['cookie'],
					$app['request'],
					$app['config'],
					$app['auth.password'],
					$app['hash'],
					$app['session'],
					$app['validator'],
					$app['cas']
			);
		});
	}

	protected function registerJournalManagementInterface()
	{
		$this->app->bind('App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface', function($app)
		{
			return new JournalManager(
					$app->make('App\Kwaai\Security\Repositories\Journal\JournalInterface'),
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app->make('AppJournalConfigurations'),
					$app->make('gravatar'),
					// new Gravatar(),
					new Carbon(),
					$app['translator'],
					$app['config']
			);
		});
	}

	protected function registerUserManagementInterface()
	{
		$this->app->bind('App\Kwaai\Security\Services\UserManagement\UserManagementInterface', function($app)
		{
			return new UserManager(
				$app->make('App\Kwaai\Security\Repositories\User\UserInterface'),
				$app->make('App\Kwaai\Organization\Repositories\Organization\OrganizationInterface'),
				$app->make('App\Kwaai\Security\Repositories\Module\ModuleInterface'),
				$app->make('App\Kwaai\Security\Repositories\Menu\MenuInterface'),
        $app->make('App\Kwaai\Security\Repositories\Role\RoleInterface'),
        $app->make('App\Kwaai\Security\Repositories\Permission\PermissionInterface'),
        $app->make('App\Kwaai\Security\Repositories\Journal\JournalInterface'),
				$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
				$app->make('App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface'),
				new \Mgallegos\LaravelJqgrid\Encoders\JqGridJsonEncoder($app->make('excel')),
				new \App\Kwaai\Security\Repositories\User\EloquentUserGridRepository(
					$app['db'],
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface')
				),
				new \App\Kwaai\Security\Repositories\User\EloquentAdminUserGridRepository(
						$app['db'],
						$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface')
				),
				new \DateTimeZone($app['config']['app.timezone']),
				$app['db'],
				$app['translator'],
				$app['hash'],
				$app['config'],
				$app['url'],
				$app['mailer'],
				$app['log'],
				$app['validator'],
				$app['cache'],
				$app['session'],
				$app['config']['app.key']
			);
		});
	}

	protected function registerAppManagementInterface()
	{
		$this->app->bind('App\Kwaai\Security\Services\AppManagement\AppManagementInterface', function($app)
		{
			return new AppManager(
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app->make('App\Kwaai\Security\Repositories\Menu\MenuInterface'),
					$app->make('App\Kwaai\Security\Repositories\Module\ModuleInterface'),
					$app->make('App\Kwaai\Security\Repositories\User\UserInterface'),
					$app['translator'],
					$app['url'],
					$app['config'],
					$app['cache']
			);
		});
	}
}

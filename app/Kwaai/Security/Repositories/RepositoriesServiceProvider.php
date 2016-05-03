<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories;

use App\Kwaai\Security\Permission;

use App\Kwaai\Security\Role;

use App\Kwaai\Security\Journal;

use App\Kwaai\Security\Menu;

use App\Kwaai\Security\Module;

use App\Kwaai\Security\Organization;

use App\Kwaai\Security\User;

use Illuminate\Support\ServiceProvider;


class RepositoriesServiceProvider extends ServiceProvider {

	/**
	 * Register a binding
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerUserInterface();

		$this->registerOrganizationInterface();

		$this->registerModuleInterface();

		$this->registerMenuInterface();

    $this->registerJournalInterface();

    $this->registerRoleInterface();

    $this->registerPermissionInterface();
	}

	/**
	 * Register a user interface instance.
	 *
	 * @return void
	 */
	protected function registerUserInterface()
	{
		$this->app->bind('App\Kwaai\Security\Repositories\User\UserInterface', function($app)
		{
			return new \App\Kwaai\Security\Repositories\User\EloquentUser( new User(), $app['db'] );
		});
	}

	/**
	 * Register a organization interface instance.
	 *
	 * @return void
	 */
	protected function registerOrganizationInterface()
	{
		$this->app->bind('App\Kwaai\Security\Repositories\Organization\OrganizationInterface', function()
		{
			return new \App\Kwaai\Security\Repositories\Organization\EloquentOrganization( new Organization() );
		});
	}

	/**
	 * Register a module interface instance.
	 *
	 * @return void
	 */
	protected function registerModuleInterface()
	{
		$this->app->bind('App\Kwaai\Security\Repositories\Module\ModuleInterface', function()
		{
			return new \App\Kwaai\Security\Repositories\Module\EloquentModule( new Module() );
		});
	}

	/**
	 * Register a menu interface instance.
	 *
	 * @return void
	 */
	protected function registerMenuInterface()
	{
		$this->app->bind('App\Kwaai\Security\Repositories\Menu\MenuInterface', function()
		{
			return new \App\Kwaai\Security\Repositories\Menu\EloquentMenu( new Menu() );
		});
	}

  /**
   * Register a journal interface instance.
   *
   * @return void
   */
  protected function registerJournalInterface()
  {
    $this->app->bind('App\Kwaai\Security\Repositories\Journal\JournalInterface', function($app)
    {
      return new \App\Kwaai\Security\Repositories\Journal\EloquentJournal( new Journal(), $app['db'] );
    });
  }

  /**
   * Register a role interface instance.
   *
   * @return void
   */
  protected function registerRoleInterface()
  {
    $this->app->bind('App\Kwaai\Security\Repositories\Role\RoleInterface', function()
    {
      return new \App\Kwaai\Security\Repositories\Role\EloquentRole( new Role());
    });
  }

   /**
    * Register a permission interface instance.
    *
    * @return void
    */
   protected function registerPermissionInterface()
   {
     $this->app->bind('App\Kwaai\Security\Repositories\Permission\PermissionInterface', function()
     {
       return new \App\Kwaai\Security\Repositories\Permission\EloquentPermission( new Permission());
     });
   }
}

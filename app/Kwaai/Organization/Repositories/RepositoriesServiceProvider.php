<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Organization\Repositories;

use App\Kwaai\Organization\Organization;

use Illuminate\Support\ServiceProvider;


class RepositoriesServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerOrganizationInterface();

		$this->registerNewOrganizationTriggerInterface();
	}

	/**
	 * Register the organization interface instance.
	 *
	 * @return void
	 */
	protected function registerOrganizationInterface()
	{
		$this->app->bind('App\Kwaai\Organization\Repositories\Organization\OrganizationInterface', function()
		{
			return new \App\Kwaai\Organization\Repositories\Organization\EloquentOrganization( new Organization() );
		});
	}

	/**
	* Register the new organization trigger interface array instance.
	*
	* @return void
	*/
	protected function registerNewOrganizationTriggerInterface()
	{
		$this->app->bind('NewOrganizationTriggerInterface', function()
		{
			return array();
		});
	}

}

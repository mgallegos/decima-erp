<?php
/**
 * @file
 * OrganizationManagement controller.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Http\Controllers\Organization;

use Illuminate\Session\SessionManager;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

use App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManagementInterface;

use App\Kwaai\Security\Services\UserManagement\UserManagementInterface;

use App\Kwaai\Security\Services\AppManagement\AppManagementInterface;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class OrganizationManager extends Controller {

	/**
	 * Organization Manager Service
	 *
	 * @var App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManagementInterface
	 *
	 */
	protected $OrganizationManagerService;

	/**
	 * User Manager Service
	 *
	 * @var App\Kwaai\Security\Services\UserManagement\UserManagementInterface
	 *
	 */
	protected $UserManagerService;

	/**
	* App Manager Service
	*
	* @var App\Kwaai\Security\Services\AppManagement\AppManagementInterface;
	*
	*/
	protected $AppManagerService;

	/**
	 * View
	 *
	 * @var Illuminate\View\Factory
	 *
	 */
	protected $View;

	/**
	 * Input
	 *
	 * @var Illuminate\Http\Request
	 *
	 */
	protected $Input;

	/**
	 * Session
	 *
	 * @var Illuminate\Session\SessionManager
	 *
	 */
	protected $Session;

	public function __construct(
		OrganizationManagementInterface $OrganizationManagerService,
		UserManagementInterface $UserManagerService,
		AppManagementInterface $AppManagerService,
		Factory $View,
		Request $Input,
		SessionManager $Session
	)
	{
		$this->OrganizationManagerService = $OrganizationManagerService;

		$this->UserManagerService = $UserManagerService;

		$this->AppManagerService = $AppManagerService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;
	}

	public function getIndex()
	{
		return $this->View->make('organization.organization-management')
						->with('showWelcomeMessage', $this->OrganizationManagerService->showWelcomeMessage())
						->with('newOrganizationAction', $this->Session->get('newOrganizationAction', $this->OrganizationManagerService->requestUserToCreateOrganization()))
						->with('editOrganizationAction', $this->Session->get('editOrganizationAction', false))
						->with('removeOrganizationAction', $this->Session->get('removeOrganizationAction', false))
						->with('hideCreatedByColumn', $this->OrganizationManagerService->hideCreatedByColumn())
						->with('currencies', $this->OrganizationManagerService->getSystemCurrencies())
						->with('appInfo', $this->AppManagerService->getAppInfo())
						->with('userOrganizations', $this->UserManagerService->getUserOrganizations())
						->with('userActions', $this->UserManagerService->getUserActions())
						->withCountries($this->OrganizationManagerService->getSystemCountries());
	}

	public function postOrganizationGridData()
	{
		return $this->OrganizationManagerService->getOrganizationGridData( $this->Input->all() );
	}

	public function postStoreOrganization()
	{
		return $this->OrganizationManagerService->save( $this->Input->json()->all() );
	}

	public function postUpdateOrganization()
	{
		return $this->OrganizationManagerService->update( $this->Input->json()->all() );
	}

	public function postDeleteOrganization()
	{
		return $this->OrganizationManagerService->delete( $this->Input->json()->all() );
	}
}

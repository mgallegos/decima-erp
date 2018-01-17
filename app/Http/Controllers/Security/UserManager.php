<?php
/**
 * @file
 * Login controller.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Http\Controllers\Security;

use App\Kwaai\Security\Services\UserManagement\UserManagementInterface;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManagementInterface;

use App\Kwaai\Security\Services\AppManagement\AppManagementInterface;

use Illuminate\Session\SessionManager;

use Illuminate\Http\Request;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class UserManager extends Controller {

	/**
	 * User Manager Service
	 *
	 * @var App\Kwaai\Security\Services\UserManagement\UserManagementInterface
	 *
	 */
	protected $UserManagerService;

	/**
	* Authentication Manager Service
	*
	* @var App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface
	*
	*/
	protected $AuthenticationManagerService;

	/**
	* Organization Manager Service
	*
	* @var App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManagementInterface
	*
	*/
	protected $OrganizationManagerService;

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
		UserManagementInterface $UserManagerService,
		AuthenticationManagementInterface $AuthenticationManagerService,
		OrganizationManagementInterface $OrganizationManagerService,
		AppManagementInterface $AppManagerService,
		Factory $View,
		Request $Input,
		SessionManager $Session
	)
	{
		$this->UserManagerService = $UserManagerService;

		$this->AuthenticationManagerService = $AuthenticationManagerService;

		$this->OrganizationManagerService = $OrganizationManagerService;

		$this->AppManagerService = $AppManagerService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;
	}

	public function getIndex()
	{
		return $this->View->make('security.user-management')
          	->with('newAdminUserAction', $this->Session->get('newAdminUserAction', false))
          	->with('newUserAction', $this->Session->get('newUserAction', false))
            ->with('removeUserAction', $this->Session->get('removeUserAction', false))
            ->with('assignRoleAction', $this->Session->get('assignRoleAction', false))
            ->with('unassignRoleAction', $this->Session->get('unassignRoleAction', false))
						->with('appInfo', $this->AppManagerService->getAppInfo())
						->with('userOrganizations', $this->UserManagerService->getUserOrganizations())
						->with('userActions', $this->UserManagerService->getUserActions())
          	->withModules($this->UserManagerService->getSystemModules())
          	->withTimezones($this->UserManagerService->getTimezones());
	}

	public function getUserPreferencesIndex()
	{
		return $this->View->make('security.user-preferences')
						->with('changesJournal', $this->UserManagerService->getUserChangesJournals())
            ->with('actionsJournal', $this->UserManagerService->getUserActionsJournals())
						->with('userDefaultOrganizationName', $this->OrganizationManagerService->getOrganizationColumnById($this->AuthenticationManagerService->getLoggedUserDefaultOrganization()))
						->with('appInfo', $this->AppManagerService->getAppInfo())
						->with('userOrganizations', $this->UserManagerService->getUserOrganizations())
						->with('userActions', $this->UserManagerService->getUserActions());
	}

	public function postStoreUser()
	{
		return $this->UserManagerService->save( $this->Input->json()->all() );
	}

	public function postUpdateUser()
	{
		return $this->UserManagerService->update( $this->Input->json()->all() );
	}

	public function postDeleteUser()
	{
		return $this->UserManagerService->delete( $this->Input->json()->all() );
	}

	public function postAssociateUser()
	{
		return $this->UserManagerService->addUserToOrganization( $this->Input->json()->all() );
	}

	public function postSetAdminUser()
	{
		return $this->UserManagerService->setUserAsAdmin( $this->Input->json()->all() );
	}

	public function postSetNonAdminUser()
	{
		return $this->UserManagerService->setUserAsNonAdmin( $this->Input->json()->all() );
	}

	public function postAccessControlList()
	{
		return $this->UserManagerService->getAccessControlList( $this->Input->json()->all() );
	}

	public function postFindUser()
	{
		return $this->UserManagerService->getUserByEmail( $this->Input->json()->all() );
	}

	public function postFindNonAdminUser()
	{
		return $this->UserManagerService->getNonAdminUserByEmail( $this->Input->json()->all() );
	}

	public function postStoreUserRoles()
	{
		return $this->UserManagerService->saveRoles( $this->Input->json()->all() );
	}

	public function postStoreUserMenus()
	{
		return $this->UserManagerService->saveMenus( $this->Input->json()->all() );
	}

	public function postResetUserMenus()
	{
		return $this->UserManagerService->resetMenus( $this->Input->json()->all() );
	}

	public function postStoreUserPermissions()
	{
		return $this->UserManagerService->savePermissions( $this->Input->json()->all() );
	}

	public function postUserAndModuleMenus()
	{
		return $this->UserManagerService->getUserAndModuleMenus( $this->Input->json()->all() );
	}

	public function postUserMenusAndPermissions()
	{
		return $this->UserManagerService->getUserMenusByModuleAndMenuPermissions( $this->Input->json()->all() );
	}

	public function postUserPermissions()
	{
		return $this->UserManagerService->getUserPermissionsByMenu( $this->Input->json()->all() );
	}

	public function postChangeLoggedUserOrganization()
	{
		return $this->UserManagerService->changeLoggedUserOrganization( $this->Input->json()->all() );
	}

	public function postUpdateLoggedUserPopoverStatus()
	{
		return $this->UserManagerService->updateloggedUserPopoverStatus( $this->Input->json()->all() );
	}

	public function postUserGridData()
	{
		return $this->UserManagerService->getUserGridData( $this->Input->all() );
	}

	public function postUserMenu()
	{
		return $this->UserManagerService->getUserMenu( $this->Input->json()->all() );
	}

	public function postAdminUserGridData()
	{
		return $this->UserManagerService->getAdminUserGridData( $this->Input->all() );
	}

}

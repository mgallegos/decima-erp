<?php
/**
 * @file
 * ModuleApp Manager Controller.
 *
 * All DecimaModule code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
namespace Vendor\DecimaModule\Module\Controllers;

use Illuminate\Session\SessionManager;

use Illuminate\Http\Request;

use Vendor\DecimaModule\Module\Services\ModuleAppManagement\ModuleAppManagementInterface;

use App\Kwaai\Security\Services\UserManagement\UserManagementInterface;

use App\Kwaai\Security\Services\AppManagement\AppManagementInterface;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class ModuleAppManager extends Controller {

	/**
	 * ModuleApp Manager Service
	 *
	 * @var Vendor\DecimaModule\Module\Services\ModuleAppManagement\ModuleAppManagementInterface
	 *
	 */
	protected $ModuleAppManagerService;

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
		ModuleAppManagementInterface $ModuleAppManagerService,
		UserManagementInterface $UserManagerService,
		AppManagementInterface $AppManagerService,
		Factory $View,
		Request $Input,
		SessionManager $Session
	)
	{
		$this->ModuleAppManagerService = $ModuleAppManagerService;

		$this->UserManagerService = $UserManagerService;

		$this->AppManagerService = $AppManagerService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;


	}

	public function getIndex()
	{
		return $this->View->make('decima-module::module-app-management')
			->with('newModuleAppAction', $this->Session->get('newModuleAppAction', false))
			->with('editModuleAppAction', $this->Session->get('editModuleAppAction', false))
			->with('deleteModuleAppAction', $this->Session->get('deleteModuleAppAction', false))
			->with('appInfo', $this->AppManagerService->getAppInfo())
			->with('userOrganizations', $this->UserManagerService->getUserOrganizations())
			->with('userAppPermissions', $this->UserManagerService->getUserAppPermissions())
			->with('userActions', $this->UserManagerService->getUserActions());
	}

	public function postGridData()
	{
		return $this->ModuleAppManagerService->getGridData( $this->Input->all() );
	}

	public function postCreate()
	{
		return $this->ModuleAppManagerService->create( $this->Input->json()->all() );
	}

	public function postUpdate()
	{
		return $this->ModuleAppManagerService->update( $this->Input->json()->all() );
	}

	public function postDelete()
	{
		return $this->ModuleAppManagerService->delete( $this->Input->json()->all() );
	}
}

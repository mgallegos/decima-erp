<?php
/**
 * @file
 * Account Manager Controller.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
namespace Vendor\DecimaModule\Module\Controllers;

use Illuminate\Session\SessionManager;

use Illuminate\Http\Request;

use Vendor\DecimaModule\Module\Services\ModuleAppManagement\ModuleAppManagementInterface;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class ModuleAppManager extends Controller {

	/**
	 * Account Manager Service
	 *
	 * @var Vendor\DecimaModule\Module\Services\ModuleAppManagement\ModuleAppManagementInterface
	 *
	 */
	protected $ModuleAppManagerService;

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

	public function __construct(ModuleAppManagementInterface $ModuleAppManagerService, Factory $View, Request $Input, SessionManager $Session)
	{
		$this->ModuleAppManagerService = $ModuleAppManagerService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;


	}

	public function getIndex()
	{
		return $this->View->make('decima-module::module-app-management')
						->with('newModuleAppAction', $this->Session->get('newModuleAppAction', false))
						->with('editModuleAppAction', $this->Session->get('editModuleAppAction', false))
						->with('deleteModuleAppAction', $this->Session->get('deleteModuleAppAction', false));
	}

	public function postGridData()
	{
		return $this->EmployeeManagerService->getGridData( $this->Input->all() );
	}

	public function postCreate()
	{
		return $this->EmployeeManagerService->create( $this->Input->json()->all() );
	}

	public function postUpdate()
	{
		return $this->EmployeeManagerService->update( $this->Input->json()->all() );
	}

	public function postDelete()
	{
		return $this->EmployeeManagerService->delete( $this->Input->json()->all() );
	}




}

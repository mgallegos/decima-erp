<?php
/**
 * @file
 * CostCenter Manager Controller.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Controllers;

use Illuminate\Session\SessionManager;

use Illuminate\Http\Request;

use Mgallegos\DecimaAccounting\Accounting\Services\CostCenterManagement\CostCenterManagementInterface;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class CostCenterManager extends Controller {

	/**
	 * CostCenter Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\SettingManagement\SettingManagementInterface
	 *
	 */
	protected $CostCenterManagement;

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

	public function __construct(CostCenterManagementInterface $CostCenterManagement, Factory $View, Request $Input, SessionManager $Session)
	{
		$this->CostCenterManagement = $CostCenterManagement;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;
	}

	public function getIndex()
	{
		return $this->View->make('decima-accounting::cost-center-management')
						->with('newCostCenterAction', $this->Session->get('newCostCenterAction', false))
						->with('editCostCenterAction', $this->Session->get('editCostCenterAction', false))
						->with('deleteCostCenterAction', $this->Session->get('deleteCostCenterAction', false))
						->with('costCenters', $this->CostCenterManagement->getGroupsCostCenters());
	}

	public function postCostCenterGridData()
	{
		return $this->CostCenterManagement->getCostCenterGridData( $this->Input->all() );
	}

	public function postCreate()
	{
		return $this->CostCenterManagement->create( $this->Input->json()->all() );
	}

	public function postUpdate()
	{
		return $this->CostCenterManagement->update( $this->Input->json()->all() );
	}

	public function postDelete()
	{
		return $this->CostCenterManagement->delete( $this->Input->json()->all() );
	}

	public function postCostCenterChildren()
	{
		return $this->CostCenterManagement->getCostCenterChildren( $this->Input->json()->all() );
	}


}

<?php
/**
 * @file
 * Initial Acounting Setup Controller.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Controllers;

use Illuminate\Session\SessionManager;

use Illuminate\Http\Request;

use Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManagementInterface;

//use App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManagementInterface;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class ProfitAndLossManager extends Controller {

	/**
	 * Journal Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManagementInterface
	 *
	 */
	protected $JournalManagerService;

	/**
	 * Organization Manager Service
	 *
	 * @var App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManagementInterface
	 *
	 */
	//protected $OrganizationManagerService;

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

	public function __construct(JournalManagementInterface $JournalManagerService, Factory $View, Request $Input, SessionManager $Session)
	{
		$this->JournalManagerService = $JournalManagerService;

		//$this->OrganizationManagerService = $OrganizationManagerService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;
	}

	public function getIndex()
	{
		return $this->View->make('decima-accounting::profit-and-loss')
						->with('filterDates', $this->JournalManagerService->getFirstAndLastDayOfCurrentMonth());
						//->with('costCenters', $this->JournalManagerService->getCostCenters());
	}


	public function postProfitAndLossGridData()
	{
		return $this->JournalManagerService->getProfitAndLossGridData( $this->Input->all() );
	}
}

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

use Mgallegos\DecimaAccounting\Accounting\Services\AccountManagement\AccountManagementInterface;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class GeneralLedgerManager extends Controller {

	/**
	 * Journal Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManagementInterface
	 *
	 */
	protected $JournalManagerService;

	/**
	 * Account Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\AccountManagement\AccountManagementInterface
	 *
	 */
	protected $AccountManagerService;

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

	public function __construct(JournalManagementInterface $JournalManagerService, AccountManagementInterface $AccountManagerService, Factory $View, Request $Input, SessionManager $Session)
	{
		$this->JournalManagerService = $JournalManagerService;

		$this->AccountManagerService = $AccountManagerService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;
	}

	public function getIndex()
	{
		return $this->View->make('decima-accounting::general-ledger')
						->with('accounts', $this->AccountManagerService->getAccounts())
						->with('filterDates', $this->JournalManagerService->getFirstAndLastDayOfCurrentMonth());
	}


	public function postGeneralLedgerGridData()
	{
		return $this->JournalManagerService->getGeneralLedgerGridData( $this->Input->all() );
	}
}

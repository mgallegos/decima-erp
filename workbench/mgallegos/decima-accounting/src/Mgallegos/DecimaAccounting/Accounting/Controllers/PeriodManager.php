<?php
/**
 * @file
 * Account Manager Controller.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Controllers;

use Illuminate\Session\SessionManager;

use Illuminate\Http\Request;

use Mgallegos\DecimaAccounting\Accounting\Services\PeriodManagement\PeriodManagementInterface;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class PeriodManager extends Controller {

	/**
	 * Period Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\PeriodManagement\PeriodManagementInterface
	 *
	 */
	protected $PeriodManagementService;

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

	public function __construct(PeriodManagementInterface $PeriodManagementService, Factory $View, Request $Input, SessionManager $Session)
	{
		$this->PeriodManagementService = $PeriodManagementService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;
	}

	public function getIndex()
	{
		return $this->View->make('decima-accounting::period-management')
						->with('openPeriodAction', $this->Session->get('openPeriodAction', false))
						->with('closePeriodAction', $this->Session->get('closePeriodAction', false));
	}

	public function postGridData()
	{
		return $this->PeriodManagementService->getGridData( $this->Input->all() );
	}

	public function postLastPeriodOfFiscalYear()
	{
		return $this->PeriodManagementService->getLastPeriodOfFiscalYear( $this->Input->json()->all() );
	}

	public function postBalanceAccountsClosingPeriods()
	{
		return $this->PeriodManagementService->getBalanceAccountsClosingPeriods( $this->Input->json()->all() );
	}

	public function postGenerate()
	{
		return $this->PeriodManagementService->generatePeriods( $this->Input->json()->all() );
	}

	public function postOpen()
	{
		return $this->PeriodManagementService->openPeriod( $this->Input->json()->all() );
	}

	public function postClose()
	{
		return $this->PeriodManagementService->closePeriod( $this->Input->json()->all() );
	}
}

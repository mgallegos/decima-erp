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

use Mgallegos\DecimaAccounting\Accounting\Services\FiscalYearManagement\FiscalYearManagementInterface;

use Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManagementInterface;

use Mgallegos\DecimaAccounting\Accounting\Services\PeriodManagement\PeriodManagementInterface;

use Mgallegos\DecimaAccounting\Accounting\Services\AccountManagement\AccountManagementInterface;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class FiscalYearManager extends Controller {

	/**
	 * FiscalYear Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\FiscalYearManagement\FiscalYearManagementInterface
	 *
	 */
	protected $FiscalYearManagerService;

	/**
	 * Journal Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManagementInterface
	 *
	 */
	protected $JournalManagerService;

	/**
	 * Period Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\PeriodManagement\PeriodManagementInterface
	 *
	 */
	protected $PeriodManagementService;

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

	public function __construct(FiscalYearManagementInterface $FiscalYearManagerService, PeriodManagementInterface $PeriodManagementService, JournalManagementInterface $JournalManagerService, AccountManagementInterface $AccountManagerService, Factory $View, Request $Input, SessionManager $Session)
	{
		$this->FiscalYearManagerService = $FiscalYearManagerService;

		$this->JournalManagerService = $JournalManagerService;

		$this->PeriodManagementService = $PeriodManagementService;

		$this->AccountManagerService = $AccountManagerService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;
	}

	public function getIndex()
	{
		return $this->View->make('decima-accounting::close-fiscal-year')
						->with('accounts', $this->AccountManagerService->getNonGroupAccounts())
						->with('costCenters', $this->JournalManagerService->getCostCenters())
						->with('voucherTypes', $this->JournalManagerService->getVoucherTypes());
	}

	public function postGridData()
	{
		return $this->FiscalYearManagerService->getGridData( $this->Input->all() );
	}

	public function postNextFiscalYear()
	{
		return $this->FiscalYearManagerService->getNextFiscalYear();
	}

	public function postExpensesVoucher()
	{
		return $this->FiscalYearManagerService->createExpensesVoucher( $this->Input->json()->all() );
	}

	public function postIncomeVoucher()
	{
		return $this->FiscalYearManagerService->createIncomeVoucher( $this->Input->json()->all() );
	}

	public function postClosingBalanceVoucher()
	{
		return $this->FiscalYearManagerService->createClosingBalanceVoucher( $this->Input->json()->all() );
	}

	public function postOpeningBalanceVoucher()
	{
		return $this->FiscalYearManagerService->createOpeningBalanceVoucher( $this->Input->json()->all() );
	}

	/*
	public function postStoreOrganization()
	{
		return $this->OrganizationManagerService->save( $this->Input->json()->all() );
	}*/
}

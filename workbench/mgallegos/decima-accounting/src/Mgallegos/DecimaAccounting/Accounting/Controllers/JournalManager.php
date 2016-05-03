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

use App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManagementInterface;

use Mgallegos\DecimaAccounting\Accounting\Services\PeriodManagement\PeriodManagementInterface;

use Mgallegos\DecimaAccounting\Accounting\Services\AccountManagement\AccountManagementInterface;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class JournalManager extends Controller {

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
	protected $OrganizationManagerService;


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

	public function __construct(JournalManagementInterface $JournalManagerService, OrganizationManagementInterface $OrganizationManagerService, PeriodManagementInterface $PeriodManagementService, AccountManagementInterface $AccountManagerService,  Factory $View, Request $Input, SessionManager $Session)
	{
		$this->JournalManagerService = $JournalManagerService;

		$this->OrganizationManagerService = $OrganizationManagerService;

		$this->PeriodManagementService = $PeriodManagementService;

		$this->AccountManagerService = $AccountManagerService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;
	}

	public function getIndex()
	{
		return $this->View->make('decima-accounting::journal-management')
						->with('newAccountingEntryAction', $this->Session->get('newAccountingEntryAction', false))
						->with('editAccountingEntryAction', $this->Session->get('editAccountingEntryAction', false))
						->with('nulifyAccountingEntryAction', $this->Session->get('nulifyAccountingEntryAction', false))
						->with('voucherTypes', $this->JournalManagerService->getVoucherTypes())
						->with('costCenters', $this->JournalManagerService->getCostCenters())
						->with('accounts', $this->AccountManagerService->getNonGroupAccounts())
						->with('users', $this->OrganizationManagerService->getUsersByOrganization())
						->with('periods', $this->PeriodManagementService->getPeriods())
						->with('periodsFilter', $this->PeriodManagementService->getPeriods2());
	}

	public function postJournalVoucherGridData()
	{
		return $this->JournalManagerService->getJournalVoucherGridData( $this->Input->all() );
	}

	public function postJournalEntryGridData()
	{
		return $this->JournalManagerService->getJournalEntryGridData( $this->Input->all() );
	}

	public function postStoreJournalVoucher()
	{
		return $this->JournalManagerService->saveJournalVoucher( $this->Input->json()->all() );
	}

	public function postUpdateJournalVoucher()
	{
		return $this->JournalManagerService->updateJournalVoucher( $this->Input->json()->all() );
	}

	public function postDeleteJournalVoucher()
	{
		return $this->JournalManagerService->deleteJournalVoucher( $this->Input->json()->all() );
	}

	public function postStoreJournalEntry()
	{
		return $this->JournalManagerService->saveJournalEntry( $this->Input->json()->all() );
	}

	public function postUpdateJournalEntry()
	{
		return $this->JournalManagerService->updateJournalEntry( $this->Input->json()->all() );
	}

	public function postDeleteJournalEntry()
	{
		return $this->JournalManagerService->deleteJournalEntry( $this->Input->json()->all() );
	}

}

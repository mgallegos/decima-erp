<?php
/**
 * @file
 * Module App Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Services\FiscalYearManagement;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface;

use Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManagementInterface as JournalManagementServiceInterface;

use App\Kwaai\Security\Repositories\Journal\JournalInterface;

use Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\EloquentFiscalYearGridRepository;

use Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface;

use Carbon\Carbon;

use Illuminate\Config\Repository;

use Illuminate\Translation\Translator;

use Illuminate\Database\DatabaseManager;


class FiscalYearManager implements FiscalYearManagementInterface {

  /**
   * Authentication Management Interface
   *
   * @var App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface
   *
   */
  protected $AuthenticationManager;

  /**
  * Journal Management Interface (Security)
  *
  * @var App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface
  *
  */
  protected $JournalManager;

  /**
	 * Journal Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManagementInterface
	 *
	 */
	protected $JournalManagerService;

  /**
  * Journal (Security)
  *
  * @var App\Kwaai\Security\Repositories\Journal\JournalInterface
  *
  */
  protected $Journal;

  /**
	 * Grid Encoder
	 *
	 * @var Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface
	 *
	 */
	protected $GridEncoder;

  /**
	 * Eloquent Grid Repository
	 *
	 * @var App\Kwaai\Template\Repositories\FiscalYear\EloquentFiscalYearGridRepository
	 *
	 */
	protected $EloquentFiscalYearGridRepository;

  /**
	 *  Fiscal Year Interface
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface
	 *
	 */
	protected $FiscalYear;

  /**
   * Journal Entry Interface
   *
   * @var Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface
   *
   */
  protected $JournalEntry;

  /**
   * Carbon instance
   *
   * @var Carbon\Carbon
   *
   */
  protected $Carbon;

  /**
   * Laravel Database Manager
   *
   * @var Illuminate\Database\DatabaseManager
   *
   */
  protected $DB;

  /**
   * Laravel Translator instance
   *
   * @var Illuminate\Translation\Translator
   *
   */
  protected $Lang;

  /**
   * Laravel Repository instance
   *
   * @var Illuminate\Config\Repository
   *
   */
  protected $Config;

	public function __construct(AuthenticationManagementInterface $AuthenticationManager, JournalManagementInterface $JournalManager, JournalManagementServiceInterface $JournalManagerService, JournalInterface $Journal, RequestedDataInterface $GridEncoder, EloquentFiscalYearGridRepository $EloquentFiscalYearGridRepository, FiscalYearInterface $FiscalYear, JournalEntryInterface $JournalEntry, Carbon $Carbon, DatabaseManager $DB, Translator $Lang, Repository $Config)
	{
    $this->AuthenticationManager = $AuthenticationManager;

    $this->JournalManager = $JournalManager;

    $this->JournalManagerService = $JournalManagerService;

    $this->Journal = $Journal;

    $this->GridEncoder = $GridEncoder;

    $this->EloquentFiscalYearGridRepository = $EloquentFiscalYearGridRepository;

    $this->FiscalYear = $FiscalYear;

    $this->JournalEntry = $JournalEntry;

    $this->Carbon = $Carbon;

    $this->DB = $DB;

		$this->Lang = $Lang;

		$this->Config = $Config;
	}

  /**
   * Echo grid data in a jqGrid compatible format
   *
   * @param array $post
   *	All jqGrid posted data
   *
   * @return void
   */
  public function getGridData(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentFiscalYearGridRepository, $post);
  }

  /**
   * Echo grid data in a jqGrid compatible format
   *
   *
   * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"year" : $year}
	 */
  public function getNextFiscalYear()
  {
    $fiscalYearId = $this->FiscalYear->lastFiscalYearByOrganization($this->AuthenticationManager->getCurrentUserOrganizationId());

    $FiscalYear = $this->FiscalYear->byId($fiscalYearId);

    return json_encode(array('fiscalYear' => $FiscalYear->year + 1));
  }

  /**
	 * Create expenses voucher
	 *
	 * @param array $input
   * 	An array as follows: array('fiscal_year_id'=>$id, 'date'=> $date, 'period_id' => periodId, 'voucher_type_id' => $voucherTypeId, 'remark' => $remark, 'cost_center_id' => $costCenterId, 'account_id' => $accountId );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessSaveMessage}
	 */
	public function createExpensesVoucher(array $input)
	{
    $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
    $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

    $input = eloquent_array_filter_for_insert($input);
		$input = array_add($input, 'organization_id', $organizationId);

    $this->DB->transaction(function() use ($input, $loggedUserId, $organizationId, &$result)
		{
      $result = json_decode($this->JournalManagerService->saveJournalVoucher(array('status'=> 'B', 'date' => $input['date'], 'remark'=> $input['remark'], 'period_id' => $input['period_id'], 'voucher_type_id' => $input['voucher_type_id'])), true);

      $entries = $this->JournalEntry->getJournalEntriesGroupedByPlBsCategoryByOrganizationAndByFiscalYear(array('C'), $organizationId, $input['fiscal_year_id']);

      $voucherEntries = array();

      $resultAccount = 0;

      foreach ($entries as $Entry)
  		{
        $credit = round($Entry->debit - $Entry->credit, 2);

        $resultAccount += $credit;

        array_push($voucherEntries, array('debit' => 0, 'credit' => $credit, 'cost_center_id' => $Entry->cost_center_id, 'account_id' => $Entry->account_id, 'journal_voucher_id' => $result['id']));
      }

      array_push($voucherEntries, array('debit' => $resultAccount, 'credit' => 0, 'cost_center_id' => $input['cost_center_id'], 'account_id' => $input['account_id'], 'journal_voucher_id' => $result['id']));

      $this->JournalEntry->massCreate($voucherEntries);

      $Journal = $this->Journal->create(array('journalized_id' => $input['fiscal_year_id'], 'journalized_type' => $this->FiscalYear->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::close-fiscal-year.expensesAddedJournal', array('number' => $result['number'], 'period' => $input['period_label'])), $Journal));
    });

    return json_encode(array('success' => $this->Lang->get('decima-accounting::close-fiscal-year.expensesAddedJournal', array('number' => $result['number'], 'period' => $input['period_label']))));
  }

  /**
	 * Create income voucher
	 *
	 * @param array $input
   * 	An array as follows: array('fiscal_year_id'=>$id, 'date'=> $date, 'period_id' => periodId, 'voucher_type_id' => $voucherTypeId, 'remark' => $remark, 'cost_center_id' => $costCenterId, 'account_id' => $accountId );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessSaveMessage}
	 */
	public function createIncomeVoucher(array $input)
	{
    $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
    $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

    $input = eloquent_array_filter_for_insert($input);
		$input = array_add($input, 'organization_id', $organizationId);

    $this->DB->transaction(function() use ($input, $loggedUserId, $organizationId, &$result)
		{
      $result = json_decode($this->JournalManagerService->saveJournalVoucher(array('status'=> 'B', 'date' => $input['date'], 'remark'=> $input['remark'], 'period_id' => $input['period_id'], 'voucher_type_id' => $input['voucher_type_id'])), true);

      $entries = $this->JournalEntry->getJournalEntriesGroupedByPlBsCategoryByOrganizationAndByFiscalYear(array('B'), $organizationId, $input['fiscal_year_id']);

      $voucherEntries = array();

      $resultAccount = 0;

      foreach ($entries as $Entry)
  		{
        $debit = round($Entry->credit - $Entry->debit, 2);

        $resultAccount += $debit;

        array_push($voucherEntries, array('debit' => $debit, 'credit' => 0, 'cost_center_id' => $Entry->cost_center_id, 'account_id' => $Entry->account_id, 'journal_voucher_id' => $result['id']));
      }

      array_push($voucherEntries, array('debit' => 0, 'credit' => $resultAccount, 'cost_center_id' => $input['cost_center_id'], 'account_id' => $input['account_id'], 'journal_voucher_id' => $result['id']));

      $this->JournalEntry->massCreate($voucherEntries);

      $Journal = $this->Journal->create(array('journalized_id' => $input['fiscal_year_id'], 'journalized_type' => $this->FiscalYear->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::close-fiscal-year.incomeAddedJournal', array('number' => $result['number'], 'period' => $input['period_label'])), $Journal));
    });

    return json_encode(array('success' => $this->Lang->get('decima-accounting::close-fiscal-year.incomeAddedJournal', array('number' => $result['number'], 'period' => $input['period_label']))));
  }

  /**
	 * Create closing balance voucher
	 *
	 * @param array $input
   * 	An array as follows: array('fiscal_year_id'=>$id, 'date'=> $date, 'period_id' => periodId, 'voucher_type_id' => $voucherTypeId, 'remark' => $remark, 'cost_center_id' => $costCenterId, 'account_id' => $accountId );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessSaveMessage}
	 */
	public function createClosingBalanceVoucher(array $input)
	{
    $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
    $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

    $input = eloquent_array_filter_for_insert($input);
		$input = array_add($input, 'organization_id', $organizationId);

    $this->DB->transaction(function() use ($input, $loggedUserId, $organizationId, &$resultClosing, &$resultOpening)
		{
      $resultClosing = json_decode($this->JournalManagerService->saveJournalVoucher(array('notransaction'=> '', 'status'=> 'B', 'date' => $input['date_closing'], 'remark'=> $input['remark_closing'], 'period_id' => $input['period_id_closing'], 'voucher_type_id' => $input['voucher_type_id_closing'])), true);
      $resultOpening = json_decode($this->JournalManagerService->saveJournalVoucher(array('notransaction'=> '', 'status'=> 'B', 'date' => $input['date_opening'], 'remark'=> $input['remark_opening'], 'period_id' => $input['period_id_opening'], 'voucher_type_id' => $input['voucher_type_id_opening'])), true);

      $entries = $this->JournalEntry->getJournalEntriesGroupedByPlBsCategoryByOrganizationAndByFiscalYear(array('D', 'E'), $organizationId, $input['fiscal_year_id']);

      $voucherClosingEntries = array();
      $voucherOpeningEntries = array();

      foreach ($entries as $Entry)
  		{
        //$Entry->balance_type
        //Deudor,Receivable:D and Acreedor,Payable: A
        if($Entry->balance_type == 'D')
        {
          $credit = round($Entry->debit - $Entry->credit, 2);
          $debit = 0;
        }
        else
        {
          $debit = round($Entry->credit - $Entry->debit, 2);
          $credit = 0;
        }

        if($debit != 0 || $credit !=0)
        {
            array_push($voucherClosingEntries, array('debit' => $debit, 'credit' => $credit, 'cost_center_id' => $Entry->cost_center_id, 'account_id' => $Entry->account_id, 'journal_voucher_id' => $resultClosing['id']));
            array_push($voucherOpeningEntries, array('debit' => $credit, 'credit' => $debit, 'cost_center_id' => $Entry->cost_center_id, 'account_id' => $Entry->account_id, 'journal_voucher_id' => $resultOpening['id']));
        }

      }

      $this->JournalEntry->massCreate($voucherClosingEntries);
      $this->JournalEntry->massCreate($voucherOpeningEntries);

      $Journal = $this->Journal->create(array('journalized_id' => $input['fiscal_year_id'], 'journalized_type' => $this->FiscalYear->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::close-fiscal-year.closingBalanceAddedJournal', array('number' => $resultClosing['number'], 'period' => $input['period_label_closing'])), $Journal));
      $this->JournalManagerService->updateJournalVoucherStatus($resultClosing['id']);
      $Journal = $this->Journal->create(array('journalized_id' => $input['fiscal_year_id_opening'], 'journalized_type' => $this->FiscalYear->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::close-fiscal-year.openingBalanceAddedJournal', array('number' => $resultOpening['number'], 'period' => $input['period_label_opening'])), $Journal));
      $this->JournalManagerService->updateJournalVoucherStatus($resultOpening['id']);
    });

    return json_encode(array('success' => $this->Lang->get('decima-accounting::close-fiscal-year.closingBalanceAddedJournal', array('number' => $resultClosing['number'], 'period' => $input['period_label_closing'])) . '<br>' . $this->Lang->get('decima-accounting::close-fiscal-year.closingBalanceAddedJournal', array('number' => $resultOpening['number'], 'period' => $input['period_label_opening']))));
  }
}

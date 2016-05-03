<?php
/**
 * @file
 * Journal Management Interface Implementation.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface as SecurityJournalManagementInterface;

use Mgallegos\DecimaAccounting\Accounting\Services\SettingManagement\SettingManagementInterface;

use App\Kwaai\Security\Repositories\Journal\JournalInterface;

use Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentJournalVoucherGridRepository;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\EloquentJournalEntryGridRepository;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentBalanceSheetGridRepository;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentProfitAndLossGridRepository;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentTrialBalanceGridRepository;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentGeneralLedgerGridRepository;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\JournalVoucherInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\VoucherType\VoucherTypeInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Account\AccountInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\CostCenterInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface;

use Carbon\Carbon;

use Illuminate\Config\Repository;

use Illuminate\Translation\Translator;

use Illuminate\Database\DatabaseManager;

/*
use Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType\AccountTypeInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface;

*/

class JournalManager implements JournalManagementInterface {

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
  * Setting Management Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Services\SettingManagement\SettingManagementInterface
  *
  */
  protected $SettingManager;

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
	 * Eloquent Journal Voucher Grid Repository
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentJournalVoucherGridRepository
	 *
	 */
	protected $EloquentJournalVoucherGridRepository;

  /**
	 * Eloquent Journal Voucher Grid Repository
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\EloquentJournalEntryGridRepository
	 *
	 */
	protected $EloquentJournalEntryGridRepository;

  /**
	 * Eloquent Balance Sheet Grid Repository
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\EloquentBalanceSheetGridRepository
	 *
	 */
	protected $EloquentBalanceSheetGridRepository;

  /**
	 * Eloquent Profit and Loss Grid Repository
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\EloquentProfitAndLossGridRepository
	 *
	 */
	protected $EloquentProfitAndLossGridRepository;

  /**
	 * Eloquent Trial Balance Grid Repository
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\EloquentProfitAndLossGridRepository
	 *
	 */
	protected $EloquentTrialBalanceGridRepository;

  /**
	 * Eloquent Trial Balance Grid Repository
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\EloquentProfitAndLossGridRepository
	 *
	 */
	protected $EloquentGeneralLedgerGridRepository;

  /**
   * Journal Voucher Interface
   *
   * @var Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\JournalVoucherInterface
   *
   */
  protected $JournalVoucher;

  /**
   * Journal Entry Interface
   *
   * @var Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface
   *
   */
  protected $JournalEntry;

  /**
  * Voucher Type Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\VoucherType\VoucherTypeInterface
  *
  */
  protected $VoucherType;

  /**
  * Account Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\Account\AccountInterface
  *
  */
  protected $Account;

  /**
  * Cost Center Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\CostCenterInterface
  *
  */
  protected $CostCenter;

  /**
  * Fiscal Year Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface
  *
  */
  protected $FiscalYear;

  /**
	 * Period Interface
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface
	 *
	 */
	protected $Period;

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

	public function __construct(AuthenticationManagementInterface $AuthenticationManager, SecurityJournalManagementInterface $JournalManager, SettingManagementInterface $SettingManager, JournalInterface $Journal, RequestedDataInterface $GridEncoder, EloquentJournalVoucherGridRepository $EloquentJournalVoucherGridRepository, EloquentJournalEntryGridRepository $EloquentJournalEntryGridRepository, EloquentBalanceSheetGridRepository $EloquentBalanceSheetGridRepository, EloquentProfitAndLossGridRepository $EloquentProfitAndLossGridRepository, EloquentTrialBalanceGridRepository $EloquentTrialBalanceGridRepository, EloquentGeneralLedgerGridRepository $EloquentGeneralLedgerGridRepository, JournalVoucherInterface $JournalVoucher, JournalEntryInterface $JournalEntry, VoucherTypeInterface $VoucherType, AccountInterface $Account, CostCenterInterface $CostCenter, FiscalYearInterface $FiscalYear, PeriodInterface $Period, Carbon $Carbon, DatabaseManager $DB, Translator $Lang, Repository $Config)
	{
    $this->AuthenticationManager = $AuthenticationManager;

    $this->JournalManager = $JournalManager;

    $this->SettingManager = $SettingManager;

    $this->Journal = $Journal;

    $this->GridEncoder = $GridEncoder;

    $this->EloquentJournalVoucherGridRepository = $EloquentJournalVoucherGridRepository;

    $this->EloquentJournalEntryGridRepository = $EloquentJournalEntryGridRepository;

    $this->EloquentBalanceSheetGridRepository = $EloquentBalanceSheetGridRepository;

    $this->EloquentProfitAndLossGridRepository = $EloquentProfitAndLossGridRepository;

    $this->EloquentTrialBalanceGridRepository = $EloquentTrialBalanceGridRepository;

    $this->EloquentGeneralLedgerGridRepository = $EloquentGeneralLedgerGridRepository;

    $this->JournalVoucher = $JournalVoucher;

    $this->JournalEntry = $JournalEntry;

    $this->VoucherType = $VoucherType;

    $this->Account = $Account;

    $this->CostCenter = $CostCenter;

    $this->FiscalYear = $FiscalYear;

    $this->Period = $Period;

    /*$this->Setting = $Setting;

    $this->AccountChartType = $AccountChartType;

    $this->Currency = $Currency;

    $this->AccountType = $AccountType;

    $this->SystemAccountType = $SystemAccountType;

    $this->Period = $Period;

    $this->SystemAccount = $SystemAccount;

    $this->SystemVoucherType = $SystemVoucherType;

		$this->Carbon = $Carbon;*/

    $this->Carbon = $Carbon;

    $this->DB = $DB;

		$this->Lang = $Lang;

		$this->Config = $Config;
	}

  /**
   * Echo journal voucher grid data in a jqGrid compatible format
   *
   * @param array $post
   *	All jqGrid posted data
   *
   * @return void
   */
  public function getJournalVoucherGridData(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentJournalVoucherGridRepository, $post);
  }

  /**
   * Echo journal entry grid data in a jqGrid compatible format
   *
   * @param array $post
   *	All jqGrid posted data
   *
   * @return void
   */
  public function getJournalEntryGridData(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentJournalEntryGridRepository, $post);
  }

  /**
   * Echo balance sheet grid data in a jqGrid compatible format
   *
   * @param array $post
   *	All jqGrid posted data
   *
   * @return void
   */
  public function getBalanceSheetGridData(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentBalanceSheetGridRepository, $post);
  }

  /**
   * Echo profit and loss grid data in a jqGrid compatible format
   *
   * @param array $post
   *	All jqGrid posted data
   *
   * @return void
   */
  public function getProfitAndLossGridData(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentProfitAndLossGridRepository, $post);
  }

  /**
   * Echo trial balance grid data in a jqGrid compatible format
   *
   * @param array $post
   *	All jqGrid posted data
   *
   * @return void
   */
  public function getTrialBalanceGridData(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentTrialBalanceGridRepository, $post);
  }

  /**
   * Echo trial balance grid data in a jqGrid compatible format
   *
   * @param array $post
   *	All jqGrid posted data
   *
   * @return void
   */
  public function getGeneralLedgerGridData(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentGeneralLedgerGridRepository, $post);
  }

  /**
   * Get voucher types
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getVoucherTypes()
  {
    $voucherTypes = array();

    $this->VoucherType->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($VoucherType) use (&$voucherTypes)
    {
      array_push($voucherTypes, array('label'=> $this->Lang->has($VoucherType->lang_key) ? $this->Lang->get($VoucherType->lang_key) : $VoucherType->name, 'value'=>$VoucherType->id));
    });

    return $voucherTypes;
  }

  /**
   * Get organization cost centers
   *
   * @return array
   *  An array of arrays as follows: array ( 'organizationCostCenters' => array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…), 'defaultCostCenter' => array('id'=>$id, 'label'=>$label))
   */
  public function getCostCenters()
  {
    $costCenters = $defaultCostCenter = array();

    $count = 0;

    $this->CostCenter->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($CostCenter) use (&$costCenters, &$count, &$defaultCostCenter)
    {
      if(empty($CostCenter->is_group))
      {
        $count++;

        if($count == 1)
        {
          $defaultCostCenter = array_add($defaultCostCenter, 'id', $CostCenter->id);
          $defaultCostCenter = array_add($defaultCostCenter, 'label', $CostCenter->key . ' ' .$CostCenter->name);
        }

        array_push($costCenters, array('label' => $CostCenter->key . ' ' .$CostCenter->name, 'value' => $CostCenter->id));
      }
    });

    if($count > 1)
    {
      $defaultCostCenter['id'] = $defaultCostCenter['label'] = '';
    }

    return array('organizationCostCenters' => $costCenters, 'defaultCostCenter' => $defaultCostCenter);
  }


  /**
   * Get organization fiscal years
   *
   * @return array
   *  An array of arrays as follows: array( $label0, label1,…)
   */
  public function getFiscalYears()
  {
    $fiscalYears = array();

    $this->FiscalYear->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($FiscalYear) use (&$fiscalYears)
    {
      array_push($fiscalYears, $FiscalYear->year);
    });

    return $fiscalYears;
  }

  /**
   * Get first day of current month
   *
   * @return array
   *  An array as follows: array( 'userFormattedFrom' => $date0, 'userFormattedTo' => $date1, 'databaseFormattedFrom' => $date2, 'databaseFormattedTo' => $date3)
   */
  public function getFirstAndLastDayOfCurrentMonth()
  {
    $Date = new Carbon('first day of this month');
    $Date2 = new Carbon('last day of this month');

    return array('userFormattedFrom' => $Date->format($this->Lang->get('form.phpShortDateFormat')), 'userFormattedTo' => $Date2->format($this->Lang->get('form.phpShortDateFormat')), 'databaseFormattedFrom' => $Date->format('Y-m-d'), 'databaseFormattedTo' => $Date2->format('Y-m-d'));
  }

  /**
	 * Create a new journal voucher
	 *
	 * @param array $input
   * 	An array as follows: array('date'=>$date, 'manual_reference'=>$manualReference, 'remark'=>$remark,
   *                              'system_reference_type'=>$systemTeferenceType, 'system_reference_field'=>$systemReferenceField, 'system_reference_id'=>$systemReferenceId
   *                              'is_editable'=>$isEditable, 'status'=>$status, 'voucher_type_id'=>$voucherTypeId
   *                            );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessSaveMessage, "id": $id, "number": $number}
	 *	In case of success and user has two organization: {"success" : form.defaultSuccessSaveMessage, "organizationMenuTooltip" : 1, "currentUserOrganization" => $currentUserOrganization, "userOrganizations" : [{id: $organizationId0, name:$organizationName0}, {id: $organizationId1, name:$organizationName1}], organizationMenuLang: Lang::get('top-bar.userOrganizations')}
	 */
	public function saveJournalVoucher(array $input)
	{
    //$input = eloquent_array_filter_for_insert($input);
    //var_dump($input);die();
    unset($input['_token'], $input['voucher_type'], $input['status_label'], $input['period_label']);
    $input = eloquent_array_filter_for_insert($input);
    $input = array_add($input, 'created_by', $this->AuthenticationManager->getLoggedUserId());
		$input = array_add($input, 'organization_id', $this->AuthenticationManager->getCurrentUserOrganizationId());
    $input['date'] = $this->Carbon->createFromFormat($this->Lang->get('form.phpShortDateFormat'), $input['date'])->format('Y-m-d');

    if(!isset($input['is_editable']))
    {
      $input = array_add($input, 'is_editable', true);
    }

    $Period = $this->Period->byId($input['period_id']);

    if($Period->is_closed)
    {
      return json_encode(array('success' => false, 'fieldValidationMessages' => array('date' => $this->Lang->get('decima-accounting::journal-management.closedPeriodValidationMessage', array('period' => $this->Lang->get('decima-accounting::period-management.' . $Period->month))))));
    }

    $this->DB->transaction(function() use (&$input, &$JournalVoucher)
		{
      $currentSettingConfiguration = $this->SettingManager->getCurrentSettingConfiguration();

      if($currentSettingConfiguration['voucher_numeration_type'] == 'P')
      {
        $input = array_add($input, 'number', $this->JournalVoucher->getMaxJournalVoucherNumberByPeriod($input['organization_id'], $input['period_id']) + 1);
      }
      else
      {
        $input = array_add($input, 'number', $this->JournalVoucher->getMaxJournalVoucherNumberByPeriodAndAccountType($input['organization_id'], $input['period_id'], $input['voucher_type_id']) + 1);
      }

      $input = array_add($input, 'number', $this->JournalVoucher->getMaxJournalVoucherNumber($input['organization_id']) + 1);

      $JournalVoucher = $this->JournalVoucher->create($input);

      $input['id'] = $JournalVoucher->id;

      $Journal = $this->Journal->create(array('journalized_id' => $JournalVoucher->id, 'journalized_type' => $this->JournalVoucher->getTable(), 'user_id' => $JournalVoucher->created_by, 'organization_id' => $JournalVoucher->organization_id));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::journal-management.journalVoucherAddedJournal', array('number' => $JournalVoucher->number)), $Journal));

    });

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage'), 'id' => $input['id'], 'number' =>$input['number'], 'numberLabel' => $this->Lang->get('decima-accounting::journal-management.voucherNumber', array('number' => $input['number']))));
  }

  /**
	 * Update an existing journal voucher
	 *
	 * @param array $input
   * 	An array as follows: array( 'id' => $id, 'date'=>$date, 'manual_reference'=>$manualReference, 'remark'=>$remark,
   *                              'system_reference_type'=>$systemTeferenceType, 'system_reference_field'=>$systemReferenceField, 'system_reference_id'=>$systemReferenceId,
   *                              'is_editable'=>$isEditable, 'status'=>$status, 'voucher_type_id'=>$voucherTypeId
   *                            );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessUpdateMessage}
	 */
	public function updateJournalVoucher(array $input)
	{
    unset($input['_token'], $input['voucher_type'], $input['status_label'], $input['period_label']);
    $input = eloquent_array_filter_for_update($input);
    $input['date'] = $this->Carbon->createFromFormat($this->Lang->get('form.phpShortDateFormat'), $input['date'])->format('Y-m-d');

    $periodIsClosed = $newPeriodIsClosed = false;

    $this->DB->transaction(function() use (&$input, &$Period, &$periodIsClosed, &$newPeriodIsClosed)
		{
      $JournalVoucher = $this->JournalVoucher->byId($input['id']);
      $unchangedJournalVoucherValues = $JournalVoucher->toArray();

      $Period = $this->Period->byId($JournalVoucher->period_id);

      if($Period->is_closed)
      {
        $periodIsClosed = true;
        return;
      }

      $Period = $this->Period->byId($input['period_id']);

      if($Period->is_closed)
      {
        $newPeriodIsClosed = true;
        return;
      }

      $this->JournalVoucher->update($input, $JournalVoucher);

      $diff = 0;

      foreach ($input as $key => $value)
      {
        if($unchangedJournalVoucherValues[$key] != $value)
        {
          $diff++;

          if($diff == 1)
          {
            $Journal = $this->Journal->create(array('journalized_id' => $JournalVoucher->id, 'journalized_type' => $this->JournalVoucher->getTable(), 'user_id' => $this->AuthenticationManager->getLoggedUserId(), 'organization_id' => $this->AuthenticationManager->getCurrentUserOrganizationId()));
          }

          if($key == 'voucher_type_id')
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::journal-management.voucherType'), 'field_lang_key' => 'decima-accounting::journal-management.voucherType', 'old_value' => $unchangedJournalVoucherValues[$key], 'new_value' => $value), $Journal);
          }
          else if ($key == 'status')
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::journal-management.' . camel_case($key)), 'field_lang_key' => 'decima-accounting::journal-management.' . camel_case($key), 'old_value' => $this->Lang->get('decima-accounting::journal-management.' . $unchangedJournalVoucherValues[$key]), 'new_value' => $this->Lang->get('decima-accounting::journal-management.' . $value)), $Journal);
          }
          else
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::journal-management.' . camel_case($key)), 'field_lang_key' => 'decima-accounting::journal-management.' . camel_case($key), 'old_value' => $unchangedJournalVoucherValues[$key], 'new_value' => $value), $Journal);
          }
        }
      }
    });

    if($periodIsClosed)
    {
      return json_encode(array('success' => false, 'info' => $this->Lang->get('decima-accounting::journal-management.closedPeriodValidationMessage3', array('period' => $this->Lang->get('decima-accounting::period-management.' . $Period->month)))));
    }

    if($newPeriodIsClosed)
    {
      return json_encode(array('success' => false, 'fieldValidationMessages' => array('date' => $this->Lang->get('decima-accounting::journal-management.closedPeriodValidationMessage', array('period' => $this->Lang->get('decima-accounting::period-management.' . $Period->month))))));
    }

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessUpdateMessage')));
  }

  /**
	 * Update the status of an existing journal voucher
	 *
   * @param  int $id Voucher id
	 * @param  App\Kwaai\Security\Repositories\Journal\JournalInterface $Journal
   *
	 * @return string
	 */
	public function updateJournalVoucherStatus($id, $Journal = null, $JournalVoucher = null, $newStatus = null)
  {
    if(empty($newStatus))
    {
      $debitSum = $this->JournalEntry->getJournalVoucherDebitSum($id);

      $creditSum = $this->JournalEntry->getJournalVoucherCreditSum($id);

      // var_dump((string) $debitSum, (string) $creditSum, $debitSum == $creditSum, round($debitSum) == round($creditSum), (string) $debitSum  == (string) $creditSum );

      if((string) $debitSum == (string) $creditSum)
      {
        $status = 'B';
      }
      else
      {
        $status = 'A';
      }
    }
    else
    {
      $status = $newStatus;
    }

    if(empty($JournalVoucher))
    {
      $JournalVoucher = $this->JournalVoucher->byId($id);
    }

    $currentStatus = $JournalVoucher->status;

    if($currentStatus != $status)
    {
      $this->JournalVoucher->update(array('status' => $status), $JournalVoucher);

      if(!empty($Journal))
      {
        $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::journal-management.status'), 'field_lang_key' => 'decima-accounting::journal-management.status', 'old_value' => $this->Lang->get('decima-accounting::journal-management.' . $currentStatus), 'new_value' => $this->Lang->get('decima-accounting::journal-management.' . $status)), $Journal);
      }
    }

    return $status;
  }

  /**
   * Delete an existing journal voucher (soft delete)
   *
   * @param int $input Voucher id
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessDeleteMessage}
   */
  public function deleteJournalVoucher($input)
  {
    $this->DB->transaction(function() use ($input)
    {
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');

      $JournalVoucher = $this->JournalVoucher->byId($input['id']);
      $Journal = $this->Journal->create(array('journalized_id' => $input['id'], 'journalized_type' => $this->JournalVoucher->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::journal-management.journalVoucherDeletedJournal', array('number' => $JournalVoucher->number)), $Journal));
      // $this->JournalVoucher->delete(array($input['id']));
      $this->JournalEntry->byJournalVoucherId($input['id'])->each(function($JournalEntry) use ($JournalVoucher, $Journal)
      {
        $this->updateJournalEntry(array('journal_voucher_id' => $JournalVoucher->id, 'journal_entry_id' => $JournalEntry->id, 'debit'=> '0.00', 'credit'=> '0.00', 'number' => $JournalVoucher->number), $Journal);
      });

      $this->updateJournalVoucherStatus($JournalVoucher->id, $Journal, $JournalVoucher, 'C');
    });

    return json_encode(array('success' => $this->Lang->get('decima-accounting::journal-management.successDeletedVoucherMessage')));
  }

  /**
	 * Create a new journal entry
	 *
	 * @param array $input
   * 	An array as follows: array('debit'=>$debit, 'credit'=>$credit, 'system_reference_type'=>$systemReferenceType, 'system_reference_field'=>$systemReferenceField,
   *                             'journal_voucher_id'=>journalVoucherId, 'cost_center_id'=>$costCenterId, 'account_id' => $accountId
   *                            );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessSaveMessage, "statusLabel": $statusLabel, "status": $status}
	 */
	public function saveJournalEntry(array $input)
	{
    $journalNumber = $input['number'];
    $unchangedInputValues = $input;
    unset($input['_token'], $input['cost_center'], $input['account'], $input['number']);
    $input = eloquent_array_filter_for_insert($input);
    $input['debit'] = remove_thousands_separator($input['debit']);
    $input['credit'] = remove_thousands_separator($input['credit']);

    $JournalVoucher = $this->JournalVoucher->byId($input['journal_voucher_id']);
    $Period = $this->Period->byId($JournalVoucher->period_id);

    if($Period->is_closed)
    {
      return json_encode(array('success' => false, 'info' => $this->Lang->get('decima-accounting::journal-management.closedPeriodValidationMessage2', array('period' => $this->Lang->get('decima-accounting::period-management.' . $Period->month)))));
    }

    $this->DB->transaction(function() use (&$input, $journalNumber, $unchangedInputValues, &$status)
		{
      $JournalEntry = $this->JournalEntry->create($input);

      $Journal = $this->Journal->create(array('journalized_id' => $JournalEntry->journal_voucher_id, 'journalized_type' => $this->JournalVoucher->getTable(), 'user_id' => $this->AuthenticationManager->getLoggedUserId(), 'organization_id' => $this->AuthenticationManager->getCurrentUserOrganizationId()));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::journal-management.journalEntryAddedJournal', array('number' => $journalNumber)), $Journal));
      // $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::journal-management.account'), 'field_lang_key' => 'decima-accounting::journal-management.account', 'new_value' => $unchangedInputValues['account']), $Journal);

      $status = $this->updateJournalVoucherStatus($JournalEntry->journal_voucher_id, $Journal);
    });

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage'), 'status' => $status, 'statusLabel' => $this->Lang->get('decima-accounting::journal-management.' . $status)));
  }

  /**
   * Update an existing journal entry
   *
   * @param array $input
   * 	An array as follows: array('journal_entry_id' => $journalEntryId, 'debit'=>$debit, 'credit'=>$credit, 'system_reference_type'=>$systemReferenceType, 'system_reference_field'=>$systemReferenceField,
   *                             'journal_voucher_id'=> journalVoucherId, 'cost_center_id'=>$costCenterId, 'account_id' => $accountId
   *                            );
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessUpdateMessage, "statusLabel": $statusLabel, "status": $status}
   */
  public function updateJournalEntry(array $input, $Journal = null)
  {
    $journalNumber = $input['number'];
    $unchangedInputValues = $input;
    $input['id'] = $input['journal_entry_id'];
    unset($input['_token'], $input['cost_center'], $input['account'], $input['number'], $input['journal_entry_id']);
    $input = eloquent_array_filter_for_update($input);
    $input['debit'] = remove_thousands_separator($input['debit']);
    $input['credit'] = remove_thousands_separator($input['credit']);

    $JournalVoucher = $this->JournalVoucher->byId($input['journal_voucher_id']);
    $Period = $this->Period->byId($JournalVoucher->period_id);

    if($Period->is_closed)
    {
      return json_encode(array('success' => false, 'info' => $this->Lang->get('decima-accounting::journal-management.closedPeriodValidationMessage2', array('period' => $this->Lang->get('decima-accounting::period-management.' . $Period->month)))));
    }

    $this->DB->transaction(function() use (&$input, $journalNumber, $unchangedInputValues, &$status, $Journal)
		{
      $JournalEntry = $this->JournalEntry->byId($input['id']);
      $unchangedJournalEntryValues = $JournalEntry->toArray();

      $this->JournalEntry->update($input, $JournalEntry);

      $diff = 0;

      foreach ($input as $key => $value)
      {
        if($unchangedJournalEntryValues[$key] != $value)
        {
          $diff++;

          if($diff == 1)
          {
            if(empty($Journal))
            {
              $Journal = $this->Journal->create(array('journalized_id' => $JournalEntry->journal_voucher_id, 'journalized_type' => $this->JournalVoucher->getTable(), 'user_id' => $this->AuthenticationManager->getLoggedUserId(), 'organization_id' => $this->AuthenticationManager->getCurrentUserOrganizationId()));
            }
          }

          if($key == 'cost_center_id')
          {
            $CostCenter = $this->CostCenter->byId($value);
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::journal-management.costCenter'), 'field_lang_key' => 'decima-accounting::journal-management.costCenter', 'old_value' => $unchangedInputValues['cost_center'], 'new_value' => $CostCenter->key . ' ' . $CostCenter->name), $Journal);
          }
          else if ($key == 'account_id')
          {
            $Account = $this->Account->byId($value);
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::journal-management.account'), 'field_lang_key' => 'decima-accounting::journal-management.account', 'old_value' => $unchangedInputValues['account'], 'new_value' => $Account->key . ' ' . $Account->name), $Journal);
          }
          else
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::journal-management.' . camel_case($key)), 'field_lang_key' => 'decima-accounting::journal-management.' . camel_case($key), 'old_value' => $unchangedJournalEntryValues[$key], 'new_value' => $value), $Journal);
          }

        }
      }
      if(empty($Journal))
      {
        $status = $this->updateJournalVoucherStatus($JournalEntry->journal_voucher_id);
      }
      else
      {
        $status = $this->updateJournalVoucherStatus($JournalEntry->journal_voucher_id, $Journal);
      }

    });

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessUpdateMessage'), 'status' => $status, 'statusLabel' => $this->Lang->get('decima-accounting::journal-management.' . $status)));

  }

  /**
	 * Delete an existing journal entry (soft delete)
	 *
	 * @param array $input
	 * 	An array as follows: array($id0, $id1,…);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessDeleteMessage}
	 */
	public function deleteJournalEntry(array $input)
	{
    $count = 0;
    $periodIsClosed = false;

		$this->DB->transaction(function() use ($input, &$count, &$status, &$periodIsClosed, &$Period)
		{
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');

      foreach ($input['id'] as $key => $id)
			{
        $count++;
        $JournalEntry = $this->JournalEntry->byId($id);

        if($count == 1)
        {
          $JournalVoucher = $this->JournalVoucher->byId($JournalEntry->journal_voucher_id);
          $Period = $this->Period->byId($JournalVoucher->period_id);

          if($Period->is_closed)
          {
            $periodIsClosed = true;
            return;
          }

          $JournalVoucher = $this->JournalVoucher->byId($JournalEntry->journal_voucher_id);
          $Journal = $this->Journal->create(array('journalized_id' => $JournalEntry->journal_voucher_id, 'journalized_type' => $this->JournalVoucher->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        }

        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::journal-management.journalEntryDeletedJournal', array('number' => $JournalVoucher->number)), $Journal));

        $this->JournalEntry->delete($input['id']);
      }

      $status = $this->updateJournalVoucherStatus($JournalVoucher->id, $Journal, $JournalVoucher);
    });

    if($periodIsClosed)
    {
      return json_encode(array('success' => false, 'info' => $this->Lang->get('decima-accounting::journal-management.closedPeriodValidationMessage2', array('period' => $this->Lang->get('decima-accounting::period-management.' . $Period->month)))));
    }

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessDeleteMessage'), 'status' => $status, 'statusLabel' => $this->Lang->get('decima-accounting::journal-management.' . $status)));
  }

}

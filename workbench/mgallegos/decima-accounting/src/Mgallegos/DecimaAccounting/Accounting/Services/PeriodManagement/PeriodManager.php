<?php
/**
 * @file
 * Module App Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Services\PeriodManagement;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface;

use App\Kwaai\Security\Repositories\Journal\JournalInterface;

use Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Period\EloquentPeriodGridRepository;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\JournalVoucherInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface;

use Carbon\Carbon;

use Illuminate\Config\Repository;

use Illuminate\Translation\Translator;

use Illuminate\Database\DatabaseManager;


class PeriodManager implements PeriodManagementInterface {

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
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\Period\EloquentPeriodGridRepository
	 *
	 */
	protected $EloquentPeriodGridRepository;

  /**
	 * Period Interface
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface
	 *
	 */
	protected $Period;

  /**
   * Journal Voucher Interface
   *
   * @var Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\JournalVoucherInterface
   *
   */
  protected $JournalVoucher;

  /**
	 *  Fiscal Year Interface
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface
	 *
	 */
	protected $FiscalYear;

  /**
   * Setting Interface
   *
   * @var Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface
   *
   */
  protected $Setting;

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

	public function __construct(AuthenticationManagementInterface $AuthenticationManager, JournalManagementInterface $JournalManager, JournalInterface $Journal, RequestedDataInterface $GridEncoder, EloquentPeriodGridRepository $EloquentPeriodGridRepository, PeriodInterface $Period, JournalVoucherInterface $JournalVoucher, FiscalYearInterface $FiscalYear, SettingInterface $Setting, Carbon $Carbon, DatabaseManager $DB, Translator $Lang, Repository $Config)
	{
    $this->AuthenticationManager = $AuthenticationManager;

    $this->JournalManager = $JournalManager;

    $this->Journal = $Journal;

    $this->GridEncoder = $GridEncoder;

    $this->EloquentPeriodGridRepository = $EloquentPeriodGridRepository;

    $this->Period = $Period;

    $this->JournalVoucher = $JournalVoucher;

    $this->FiscalYear = $FiscalYear;

    $this->Setting = $Setting;

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
    $this->GridEncoder->encodeRequestedData($this->EloquentPeriodGridRepository, $post);
  }

  /**
   * Get periods
   *
   * @return array
   *  An array of arrays as follows: array( array('id' => $id0, 'month' => $month0, 'startDate'=>$startDate0, 'endDate'=>$endDate0), array('id' => $id1, 'month' => $month1, 'startDate'=>$startDate1, 'endDate'=>$endDate1),…)
   */
  public function getPeriods()
  {
    $periods = array();

    $this->Period->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($Period) use (&$periods)
    {
      array_push($periods, array('id'=> $Period->id, 'month' => $this->Lang->get('decima-accounting::period-management.' . $Period->month), 'startDate'=>$Period->start_date, 'endDate'=>$Period->end_date));
    });

    return $periods;
  }

  /**
   * Get periods
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$month0 . $year0, 'value'=>$id0), array('label'=>$month1 . $year1, 'value'=>$id1),…)
   */
  public function getPeriods2()
  {
    $periods = array();

    $this->Period->byOrganizationWithYear($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($Period) use (&$periods)
    {
      // array_push($periods, array('value'=> $Period->id, 'label' => $this->Lang->get('decima-accounting::period-management.' . $Period->month) . ' ' . $Period->year->year));
      array_push($periods, array('value'=> $Period->id, 'label' => $this->Lang->get('decima-accounting::period-management.' . $Period->month) . ' ' . $Period->year));
    });

    return $periods;
  }

  /**
   * Get last period of fiscal year
   *
   * @param array $input
	 * 	An array as follows: array(id => $id);
   *
   * @return array
   *  An array as follows: array( 'id' = $id, 'month' => $month, 'end_date' => $endDate)
   */
  public function getLastPeriodOfFiscalYear(array $input)
  {
    $period = $this->Period->lastPeriodbyOrganizationAndByFiscalYear($this->AuthenticationManager->getCurrentUserOrganizationId(), $input['id'])->toArray();

    $period['endDate'] = $this->Carbon->createFromFormat('Y-m-d', $period['end_date'])->format($this->Lang->get('form.phpShortDateFormat'));
    unset($period['end_date']);
    $period['month'] = $period['month'] . ' - ' . $this->Lang->get('decima-accounting::period-management.' . $period['month']);

    return json_encode($period);
  }

  /**
   * Get last period of fiscal year and first period of the next fiscal year
   *
   * @param array $input
	 * 	An array as follows: array(id => $id);
   *
   * @return array
   *  An array as follows: array( 'id' = $id, 'month' => $month, 'end_date' => $endDate)
   */
  public function getBalanceAccountsClosingPeriods(array $input)
  {
    $organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');

    $fiscalYearId = $this->FiscalYear->lastFiscalYearByOrganization($organizationId);

    if($fiscalYearId == $input['id'])
    {
      return json_encode(array('info' => $this->Lang->get('decima-accounting::period-management.invalidFiscalYear')));
    }

    $period = json_decode($this->getLastPeriodOfFiscalYear($input), true);

    $FiscalYear = $this->FiscalYear->byId($input['id']);

    $FiscalYear = $this->FiscalYear->byYearAndByOrganization($FiscalYear->year + 1, $organizationId);

    $period2 = $this->Period->firstPeriodbyOrganizationAndByFiscalYear($this->AuthenticationManager->getCurrentUserOrganizationId(), $FiscalYear->id)->toArray();

    $period2['endDate'] = $this->Carbon->createFromFormat('Y-m-d', $period2['end_date'])->format($this->Lang->get('form.phpShortDateFormat'));
    unset($period2['end_date']);
    $period2['month'] = $period2['month'] . ' - ' . $this->Lang->get('decima-accounting::period-management.' . $period2['month']);

    return json_encode(array('id0' => $period['id'], 'month0' => $period['month'], 'endDate0' => $period['endDate'], 'id1' => $period2['id'], 'month1' => $period2['month'], 'endDate1' => $period2['endDate'], 'fiscalYearId' => $FiscalYear->id));
  }

  /**
   * Create fiscal year and periods
   *
   * @param array $input
	 * 	An array as follows: array(year => $year);
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessOperationMessage}
   */
  public function generatePeriods(array $input)
  {
    $this->DB->transaction(function() use ($input)
    {
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');

      $Setting = $this->Setting->byOrganization($organizationId)->first();

      $firstDayYear = date($input['year'] .'-01-01');

      $lastDayYear = date($input['year'] .'-12-31');

      $FiscalYear = $this->FiscalYear->create(array('year' => $input['year'], 'start_date' => $firstDayYear, 'end_date' => $lastDayYear, 'organization_id' => $organizationId));

      $Journal = $this->Journal->create(array('journalized_id' => $FiscalYear->id, 'journalized_type' => $this->FiscalYear->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.fiscalYearAddedJournal', array('year' => $input['year']))), $Journal);

      if(!empty($Setting->create_opening_period))
      {
        $Period = $this->Period->create(array('month' => 0, 'start_date' => $firstDayYear, 'end_date' => $firstDayYear, 'fiscal_year_id' => $FiscalYear->id,  'organization_id' => $organizationId));

        $Journal = $this->Journal->create(array('journalized_id' => $Period->id, 'journalized_type' => $this->Period->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.periodAddedJournal', array('period' => 0))), $Journal);
      }

      for ($i = 1; $i <= 12; $i++)
      {
        $Date = new \DateTime($input['year'] . '-' . $i .'-01');
        $firstDay = $Date->format('Y-m-d');
        $Date->modify('last day of this month');
        $lastDay = $Date->format('Y-m-d');
        $Period = $this->Period->create(array('month' => $i, 'start_date' => $firstDay, 'end_date' => $lastDay, 'fiscal_year_id' => $FiscalYear->id, 'organization_id' => $organizationId));

        $Journal = $this->Journal->create(array('journalized_id' => $Period->id, 'journalized_type' => $this->Period->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.periodAddedJournal', array('period' => $i))), $Journal);
      }

      if(!empty($Setting->create_closing_period))
      {
        $Period = $this->Period->create(array('month' => 13, 'start_date' => $lastDayYear, 'end_date' => $lastDayYear, 'fiscal_year_id' => $FiscalYear->id, 'organization_id' => $organizationId));

        $Journal = $this->Journal->create(array('journalized_id' => $Period->id, 'journalized_type' => $this->Period->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.periodAddedJournal', array('period' => 13))), $Journal);
      }
    });

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessOperationMessage')));
  }

  /**
   * Open an existing period
   *
   * @param array $input
	 * 	An array as follows: array(id => $id);
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessOperationMessage}
   */
  public function openPeriod(array $input)
  {
    $this->DB->transaction(function() use ($input)
    {
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');

      $Period = $this->Period->byId($input['id']);
      $Journal = $this->Journal->create(array('journalized_id' => $input['id'], 'journalized_type' => $this->Period->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      // $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::journal-management.status'), 'field_lang_key' => 'decima-accounting::journal-management.status', 'old_value' => $this->Lang->get('decima-accounting::period-management.closed'), 'new_value' => $this->Lang->get('decima-accounting::period-management.opened')), $Journal);
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::period-management.periodOpenedJournal', array('period' => $this->Lang->get('decima-accounting::period-management.' . $Period->month))), $Journal));
      $this->Period->update(array('is_closed' => false), $Period);
    });

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessOperationMessage')));
  }

  /**
   * Close an existing period
   *
   * @param array $input
	 * 	An array as follows: array(id => $id);
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessOperationMessage}
   */
  public function closePeriod(array $input)
  {
    $canBeClosed = true;

    $this->DB->transaction(function() use ($input, &$canBeClosed)
    {
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');

      if($this->JournalVoucher->getByOrganizationByPeriodAndByStatus($organizationId, array($input['id']), 'A')->count() > 0)
      {
        $canBeClosed = false;
        return;
      }

      $Period = $this->Period->byId($input['id']);
      $Journal = $this->Journal->create(array('journalized_id' => $input['id'], 'journalized_type' => $this->Period->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      // $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::journal-management.status'), 'field_lang_key' => 'decima-accounting::journal-management.status', 'old_value' => $this->Lang->get('decima-accounting::period-management.opened'), 'new_value' => $this->Lang->get('decima-accounting::period-management.closed')), $Journal);
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::period-management.periodClosedJournal', array('period' => $this->Lang->get('decima-accounting::period-management.' . $Period->month))), $Journal));
      $this->Period->update(array('is_closed' => true), $Period);
    });

    if(!$canBeClosed)
    {
      return json_encode(array('success' => false, 'info' => $this->Lang->get('decima-accounting::period-management.voucherException')));
    }

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessOperationMessage')));
  }
}

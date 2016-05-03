<?php
/**
 * @file
 * Setting Management Interface Implementation.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Services\SettingManagement;

use Illuminate\Config\Repository;

use Illuminate\Translation\Translator;

use Illuminate\Database\DatabaseManager;

//use Carbon\Carbon;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface;

use Mgallegos\DecimaAccounting\System\Repositories\AccountChartType\AccountChartTypeInterface;

use App\Kwaai\System\Repositories\Currency\CurrencyInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType\AccountTypeInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\VoucherType\VoucherTypeInterface;

use Mgallegos\DecimaAccounting\System\Repositories\AccountType\AccountTypeInterface as SystemAccountTypeInterface;

use Mgallegos\DecimaAccounting\System\Repositories\Account\AccountInterface as SystemAccountInterface;

use Mgallegos\DecimaAccounting\System\Repositories\VoucherType\VoucherTypeInterface as SystemVoucherTypeInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Account\AccountInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\CostCenterInterface;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface;

use App\Kwaai\Security\Repositories\Journal\JournalInterface;

class SettingManager implements SettingManagementInterface {

  /**
   * Setting Interface
   *
   * @var Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface
   *
   */
  protected $Setting;


  /**
  * AccountChart Type Interface
  *
  * @var Mgallegos\DecimaAccounting\System\Repositories\AccountChartType\AccountChartTypeInterface
  *
  */
  protected $AccountChartType;

  /**
  * Currency Interface
  *
  * @var App\Kwaai\System\Repositories\Currency\CurrencyInterface
  *
  */
  protected $Currency;

  /**
  * Account Type Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType\AccountTypeInterface
  *
  */
  protected $AccountType;

  /**
  * System Account Type Interface
  *
  * @var Mgallegos\DecimaAccounting\System\Repositories\AccountType\AccountTypeInterface
  *
  */
  protected $SystemAccountType;

  /**
  * Period Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface
  *
  */
  protected $Period;

  /**
  * Fiscal Year Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface
  *
  */
  protected $FiscalYear;

  /**
  * Account Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\Account\AccountInterface
  *
  */
  protected $Account;

  /**
  * System Account Interface
  *
  * @var Mgallegos\DecimaAccounting\System\Repositories\Account\AccountInterface
  *
  */
  protected $SystemAccount;

  /**
  * Voucher Type Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\VoucherType\VoucherTypeInterface
  *
  */
  protected $VoucherType;

  /**
  * System Voucher Type Interface
  *
  * @var Mgallegos\DecimaAccounting\System\Repositories\VoucherType\VoucherTypeInterface
  *
  */
  protected $SystemVoucherType;

  /**
  * Cost Center Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\CostCenterInterface
  *
  */
  protected $CostCenter;

  /**
   * Authentication Management Interface
   *
   * @var App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface
   *
   */
  protected $AuthenticationManager;

  /**
  * Journal Management Interface
  *
  * @var App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface
  *
  */
  protected $JournalManager;

  /**
  * Journal
  *
  * @var App\Kwaai\Security\Repositories\Journal\JournalInterface
  *
  */
  protected $Journal;

  /**
   * Carbon instance
   *
   * @var Carbon\Carbon
   *
   */
  //protected $Carbon;

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

	public function __construct(SettingInterface $Setting, AccountChartTypeInterface $AccountChartType, CurrencyInterface $Currency, AccountTypeInterface $AccountType, SystemAccountTypeInterface $SystemAccountType, PeriodInterface $Period, FiscalYearInterface $FiscalYear, AccountInterface $Account, SystemAccountInterface $SystemAccount, VoucherTypeInterface $VoucherType, SystemVoucherTypeInterface $SystemVoucherType, CostCenterInterface $CostCenter, AuthenticationManagementInterface $AuthenticationManager, JournalManagementInterface $JournalManager, JournalInterface $Journal,/*Carbon $Carbon,*/DatabaseManager $DB, Translator $Lang, Repository $Config)
	{
		$this->Setting = $Setting;

    $this->AccountChartType = $AccountChartType;

    $this->Currency = $Currency;

    $this->AccountType = $AccountType;

    $this->SystemAccountType = $SystemAccountType;

    $this->Period = $Period;

    $this->FiscalYear = $FiscalYear;

    $this->Account = $Account;

    $this->SystemAccount = $SystemAccount;

    $this->VoucherType = $VoucherType;

    $this->SystemVoucherType = $SystemVoucherType;

    $this->CostCenter = $CostCenter;

		$this->AuthenticationManager = $AuthenticationManager;

    $this->JournalManager = $JournalManager;

    $this->Journal = $Journal;

		//$this->Carbon = $Carbon;

    $this->DB = $DB;

		$this->Lang = $Lang;

		$this->Config = $Config;
	}

  /**
  * Get years
  *
  * @return array
  *  An array of arrays as follows: array($year0 => $year0, $year1 => $year1,… )
  */
  public function getYears()
  {
    $years = array();

    foreach (range(date('Y'), 1950) as $x)
    {
      $years = array_add($years, $x, $x);
    }

    return $years;
  }

	/**
	 * Get country accounts chart types.
	 *
   * @return array
   *  An array of arrays as follows: array(array('id' => $id, 'name' => $name, 'url' => $url),…)
	 */
	public function getCountryAccountsChartsTypes()
	{
    $accountsChartsTypes = array();

    $this->AccountChartType->accountsChartsTypesByCountry($this->AuthenticationManager->getCurrentUserOrganizationCountry())->each(function($AccountChartType) use(&$accountsChartsTypes)
    {
      $name = $this->Lang->has($AccountChartType->lang_key) ? $this->Lang->get($AccountChartType->lang_key) : $AccountChartType->name;
      array_push($accountsChartsTypes, array('id' => $AccountChartType->id, 'name' => $name, 'url' => $AccountChartType->url));
    });

    return $accountsChartsTypes;

	}

  /**
  * Get system currencies
  *
  * @return array
  *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
  */
  public function getSystemCurrencies()
  {
    $currencies = array();

    $this->Currency->all()->each(function($Currency) use (&$currencies)
    {
      array_push($currencies, array('label'=> $Currency->name . ' (' . $Currency->symbol . ')', 'value'=>$Currency->id));
    });

    return $currencies;
  }

  /**
  * Get current setting configuration
  *
  * @return array
  */
  public function getCurrentSettingConfiguration()
  {
    return $this->Setting->byOrganization($this->AuthenticationManager->getCurrentUserOrganization('id'))->first()->toArray();
  }

  /**
  * Get Setting Journals
  *
  * @return array
  */
  public function getSettingJournals()
  {
    return $this->JournalManager->getJournalsByApp(array('appId' => 'acct-initial-acounting-setup', 'page' => 1, 'journalizedId' => $this->Setting->byOrganization($this->AuthenticationManager->getCurrentUserOrganization('id'))->first()->id, 'filter' => null, 'userId' => null, 'onlyActions' => false), true);
  }

  /**
  * Get current setting configuration
  *
  * @return array
  */
  public function isAccountingSetup()
  {
    $Setting = $this->Setting->byOrganization($this->AuthenticationManager->getCurrentUserOrganization('id'))->first();

    if(empty($Setting->is_configured))
    {
      return false;
    }
    else
    {
      return true;
    }
  }

  /**
  * Update accounting setting
  *
  * @param array $input
  *   An array as follows: array('courses'=> array($id0, $id1,…), 'costCenters'=> array($key0, $key1,…));
  *
  * @return JSON encoded string
  *  A string as follows:
  *  {
  *  	totalEmployees: $totalEmployees
  *  	payrollEmployees: $payrollEmployees
  *  	serviceEmployees: $serviceEmployees
  *  }
  */
  public function updateAccountingSettings(array $input = array())
  {
    $organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');

    $loggedUserId = $this->AuthenticationManager->getLoggedUserId();

    $Setting = $this->Setting->byOrganization($organizationId)->first();

    $this->DB->transaction(function() use ($Setting, $input, $organizationId, $loggedUserId)
    {
      $SettingJournal = $this->Journal->create(array('journalized_id' => $Setting->id, 'journalized_type' => $this->Setting->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));

      if(empty($Setting->is_configured))
      {
        $organizationAccountsType = array();

        $this->SystemAccountType->all()->each(function($AccountType) use ($organizationId, &$organizationAccountsType, $loggedUserId)
        {
          $accountType = $AccountType->toArray();
          $accountType = array_add($accountType, 'organization_id', $organizationId);
          $accountType['name'] = $this->Lang->has($accountType['lang_key']) ? $this->Lang->get($accountType['lang_key']) : $accountType['name'];
          unset($accountType['id'], $accountType['created_at'], $accountType['updated_at'], $accountType['deleted_at']);

          $AccountType = $this->AccountType->create($accountType);
          $organizationAccountsType = array_add($organizationAccountsType, $AccountType->key, $AccountType->id);

          $Journal = $this->Journal->create(array('journalized_id' => $AccountType->id, 'journalized_type' => $this->AccountType->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
          $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.accountTypeAddedJournal', array('type' => $this->Lang->has($AccountType->lang_key) ? $this->Lang->get($AccountType->lang_key) : $AccountType->name))), $Journal);
        });

        $this->Journal->attachDetail($SettingJournal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.accountTypeSettingAddedJournal')), $SettingJournal);

        $this->SystemVoucherType->all()->each(function($VoucherType) use ($organizationId, $loggedUserId)
        {
          $voucherType = $VoucherType->toArray();
          $voucherType = array_add($voucherType, 'organization_id', $organizationId);
          $voucherType['name'] = $this->Lang->has($voucherType['lang_key']) ? $this->Lang->get($voucherType['lang_key']) : $voucherType['name'];
          unset($voucherType['id'], $voucherType['created_at'], $voucherType['updated_at'], $voucherType['deleted_at']);

          $VoucherType = $this->VoucherType->create($voucherType);

          $Journal = $this->Journal->create(array('journalized_id' => $VoucherType->id, 'journalized_type' => $this->VoucherType->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
          $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.voucherTypeAddedJournal', array('type' => $this->Lang->has($VoucherType->lang_key) ? $this->Lang->get($VoucherType->lang_key) : $VoucherType->name))), $Journal);
        });

        $this->Journal->attachDetail($SettingJournal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.voucherTypeSettingAddedJournal')), $SettingJournal);

        $firstDayYear = date($input['year'] .'-01-01');

        $lastDayYear = date($input['year'] .'-12-31');

        $FiscalYear = $this->FiscalYear->create(array('year' => $input['year'], 'start_date' => $firstDayYear, 'end_date' => $lastDayYear, 'organization_id' => $organizationId));

        $Journal = $this->Journal->create(array('journalized_id' => $FiscalYear->id, 'journalized_type' => $this->FiscalYear->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.fiscalYearAddedJournal', array('year' => $input['year']))), $Journal);
        $this->Journal->attachDetail($SettingJournal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.fiscalYearAddedJournal', array('year' => $input['year']))), $SettingJournal);


        if($input['create_opening_period'] == '1')
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

        if($input['create_closing_period'] == '1')
        {
          $Period = $this->Period->create(array('month' => 13, 'start_date' => $lastDayYear, 'end_date' => $lastDayYear, 'fiscal_year_id' => $FiscalYear->id, 'organization_id' => $organizationId));

          $Journal = $this->Journal->create(array('journalized_id' => $Period->id, 'journalized_type' => $this->Period->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
          $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.periodAddedJournal', array('period' => 13))), $Journal);
        }

        $this->Journal->attachDetail($SettingJournal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.periodAddedSettingJournal')), $SettingJournal);

        $CostCenter = $this->CostCenter->create(array('name' => $this->AuthenticationManager->getCurrentUserOrganizationName(), 'key' => $this->Config->get('accounting-general.default_organization_cc_key'), 'is_group' => true, 'organization_id' => $organizationId));

        $Journal = $this->Journal->create(array('journalized_id' => $CostCenter->id, 'journalized_type' => $this->CostCenter->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.costCenterAddedJournal', array('costCenter' => $CostCenter->key . ' ' . $CostCenter->name))), $Journal);

        $CostCenter = $this->CostCenter->create(array('name' => $this->Lang->get('decima-accounting::cost-center.main'), 'key' => $this->Config->get('accounting-general.default_main_cc_key'), 'is_group' => false, 'parent_cc_id' => $CostCenter->id, 'organization_id' => $organizationId));

        $Journal = $this->Journal->create(array('journalized_id' => $CostCenter->id, 'journalized_type' => $this->CostCenter->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.costCenterAddedJournal', array('costCenter' => $CostCenter->key . ' ' . $CostCenter->name))), $Journal);
        $this->Journal->attachDetail($SettingJournal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.costCenterAddedSettingJournal')), $SettingJournal);

        $organizationAccounts = array();

        $this->SystemAccount->accountsByAccountChartsTypes($input['account_chart_type_id'])->each(function($SystemAccount) use ($organizationId, $organizationAccountsType, &$organizationAccounts, &$systemAccountsCounter, $loggedUserId)
        {
          $account = $SystemAccount->toArray();
          $account = array_add($account, 'organization_id', $organizationId);
          $account = array_add($account, 'account_type_id', $organizationAccountsType[$account['account_type_key']]);

          if(!empty($account['parent_key']))
          {
            $account = array_add($account, 'parent_account_id', $organizationAccounts[$account['parent_key']]);
          }

          unset($account['id'], $account['parent_key'], $account['account_type_key'], $account['account_chart_type_id'], $account['created_at'], $account['updated_at'], $account['deleted_at']);

          $OrganizationAccount = $this->Account->create($account);

          $Journal = $this->Journal->create(array('journalized_id' => $OrganizationAccount->id, 'journalized_type' => $this->Account->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
          $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.accountAddedJournal', array('account' => $OrganizationAccount->key . ' ' . $OrganizationAccount->name))), $Journal);

          $organizationAccounts[$OrganizationAccount->key] = $OrganizationAccount->id;
        });

        if(!empty($organizationAccounts))
        {
          $AccountChartType = $this->AccountChartType->byId($input['account_chart_type_id']);
          $this->Journal->attachDetail($SettingJournal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.accountAddedSettingJournal', array('catalog' => $AccountChartType->name))), $SettingJournal);
        }

        $input['id'] = $Setting->id;
        $input['initial_year'] = $input['year'];
        $input['is_configured'] = true;
        unset($input['_token'], $input['year']);

        $this->Setting->update($input);
      }
      else
      {
        $input['id'] = $Setting->id;
        $unchangedSettingValues = $Setting->toArray();
        unset($input['_token'], $input['year'], $input['account_chart_type_id']);
        $this->Setting->update($input);

        $diff = 0;

        foreach ($input as $key => $value)
        {
          if($unchangedSettingValues[$key] != $value)
          {
            $diff++;

            if($diff == 1)
            {
              $Journal = $this->Journal->create(array('journalized_id' => $Setting->id, 'journalized_type' => $this->Setting->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
            }

            $fieldLangKey = 'decima-accounting::initial-accounting-setup.' . camel_case($key);

            if($key == 'voucher_numeration_type')
            {
              $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get($fieldLangKey), 'field_lang_key' => $fieldLangKey, 'old_value' => $this->Lang->get('decima-accounting::initial-accounting-setup.' . $unchangedSettingValues[$key]), 'new_value' => $this->Lang->get('decima-accounting::initial-accounting-setup.' . $value)), $Journal);
            }
            else
            {
              $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get($fieldLangKey), 'field_lang_key' => $fieldLangKey, 'old_value' => $this->Lang->get('journal.' . $unchangedSettingValues[$key]), 'new_value' => $this->Lang->get('journal.' . $value)), $Journal);
            }
          }
        }
      }
    });

    return json_encode(array('success' => $this->Lang->get('decima-accounting::initial-accounting-setup.successUpdateMessage')));
  }

}

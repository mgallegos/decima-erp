<?php
/**
 * @file
 * Account Management Interface Implementation.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Services\AccountManagement;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface as SecurityJournalManagementInterface;

use App\Kwaai\Security\Repositories\Journal\JournalInterface;

use Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Account\EloquentAccountGridRepository;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Account\AccountInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType\AccountTypeInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface;

use Carbon\Carbon;

use Illuminate\Config\Repository;

use Illuminate\Translation\Translator;

use Illuminate\Database\DatabaseManager;

class AccountManager implements AccountManagementInterface {

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
	 * Eloquent Journal Voucher Grid Repository
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\Account\EloquentAccountGridRepository
	 *
	 */
	protected $EloquentAccountGridRepository;

  /**
  * Account Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\Account\AccountInterface
  *
  */
  protected $Account;

  /**
  * Account Type Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType\AccountTypeInterface
  *
  */
  protected $AccountType;

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

	public function __construct(AuthenticationManagementInterface $AuthenticationManager, SecurityJournalManagementInterface $JournalManager, JournalInterface $Journal, RequestedDataInterface $GridEncoder, EloquentAccountGridRepository $EloquentAccountGridRepository, AccountInterface $Account, AccountTypeInterface $AccountType, JournalEntryInterface $JournalEntry, Carbon $Carbon, DatabaseManager $DB, Translator $Lang, Repository $Config)
	{
    $this->AuthenticationManager = $AuthenticationManager;

    $this->JournalManager = $JournalManager;

    $this->Journal = $Journal;

    $this->GridEncoder = $GridEncoder;

    $this->EloquentAccountGridRepository = $EloquentAccountGridRepository;

    $this->Account = $Account;

    $this->AccountType = $AccountType;

    $this->JournalEntry = $JournalEntry;

    $this->Carbon = $Carbon;

    $this->DB = $DB;

		$this->Lang = $Lang;

		$this->Config = $Config;
	}

  /**
   * Echo account grid data in a jqGrid compatible format
   *
   * @param array $post
   *	All jqGrid posted data
   *
   * @return void
   */
  public function getAccountGridData(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentAccountGridRepository, $post);
  }

  /**
   * Get organization accounts
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getAccounts()
  {
    //Is Group: Further accounts can be made under Groups, but entries can be made against non-Groups
    $accounts = array();

    $this->Account->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($Account) use (&$accounts)
    {
      array_push($accounts, array('label'=> $Account->key . ' ' . $Account->name, 'value'=>$Account->id));
    });

    return $accounts;
  }

  /**
   * Get group organization accounts
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getGroupsAccounts()
  {
    //Is Group: Further accounts can be made under Groups, but entries can be made against non-Groups
    $accounts = array();

    $this->Account->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($Account) use (&$accounts)
    {
      if($Account->is_group)
      {
        array_push($accounts, array('label'=> $Account->key . ' ' . $Account->name, 'value'=>$Account->id));
      }
    });

    return $accounts;
  }

  /**
   * Get non-group organization accounts
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getNonGroupAccounts()
  {
    //Is Group: Further accounts can be made under Groups, but entries can be made against non-Groups
    $accounts = array();

    $this->Account->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($Account) use (&$accounts)
    {
      if(empty($Account->is_group))
      {
        array_push($accounts, array('label'=> $Account->key . ' ' . $Account->name, 'value'=>$Account->id));
      }
    });

    return $accounts;
  }

  /**
   * Get accounts children
   *
   * @param array $input
   * 	An array as follows: array('id'=>$id);
   *
   * @return JSON encoded string
   *  A string as follows: {$id0, $id1,…}
   */
  public function getAccountChildrenIdsJson(array $input)
  {
    return json_encode($this->getAccountChildrenIds($input['id']));
  }

  /**
   * Get balance types
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getBalanceTypes()
  {
    return array(array('label' => $this->Lang->get('decima-accounting::account-management.D'), 'value'=> 'D'), array('label' => $this->Lang->get('decima-accounting::account-management.A'), 'value'=> 'A'));
  }

  /**
   * Get organization accounts types
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getAccountsTypes()
  {
    //Is Group: Further accounts can be made under Groups, but entries can be made against non-Groups
    $accountTypes = array();

    $this->AccountType->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($AccountType) use (&$accountTypes)
    {
      array_push($accountTypes, array('label'=> $AccountType->name, 'value'=>$AccountType->id));
    });

    return $accountTypes;
  }

  /**
	 * Create a new account
	 *
	 * @param array $input
   * 	An array as follows: array('key'=>$key, 'name'=>$name, 'balance_type'=>$balanceType, 'is_group'=>$isGroup,
   *                              'account_type_id'=>$accountTypeId, 'parent_account_id'=>$parentAccountId
   *                            );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessSaveMessage}
	 */
	public function create(array $input)
	{
    unset($input['_token'], $input['parent_account'], $input['balance_type_name'], $input['account_type']);

    $groupsAccounts = $info = false;

    $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
    $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

    $input = eloquent_array_filter_for_insert($input);
		$input = array_add($input, 'organization_id', $organizationId);

    $this->DB->transaction(function() use ($input, $loggedUserId, $organizationId, &$groupsAccounts, &$info)
		{
      if($this->Account->byOrganizationAndByKey($organizationId, $input['key'])->count() > 0)
      {
        $info = $this->Lang->get('decima-accounting::account-management.keyValidationMessage', array('key' => $input['key']));
        return;
      }

      $Account = $this->Account->create($input);

      $Journal = $this->Journal->create(array('journalized_id' => $Account->id, 'journalized_type' => $this->Account->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.accountAddedJournal', array('account' => $Account->key . ' ' . $Account->name)), $Journal));

      if(!empty($Account->is_group))
      {
        $groupsAccounts = $this->getGroupsAccounts();
      }
    });

    if(!$info)
    {
      return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage'), 'groupsAccounts' => $groupsAccounts));
    }
    else
    {
      return json_encode(array('info' => $info));
    }
  }

  /**
	 * Update an existing account
	 *
	 * @param array $input
   * 	An array as follows: array('id' => $id, 'key'=>$key, 'name'=>$name, 'balance_type'=>$balanceType, 'is_group'=>$isGroup,
   *                             'account_type_id'=>$accountTypeId, 'parent_account_id'=>$parentAccountId, 'parent_account' => $parentAccount
   *                             'account_type' => $accountType, 'parent_account' => $parentAccount
   *                            );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessUpdateMessage}
	 */
	public function update(array $input)
	{
    $newParentAccount = $input['parent_account'];
    $newAccountType = $input['account_type'];
    $groupsAccounts = $info = false;

    unset($input['_token'], $input['parent_account'], $input['balance_type_name'], $input['account_type']);
    $input = eloquent_array_filter_for_update($input);
    // $input['date'] = $this->Carbon->createFromFormat($this->Lang->get('form.phpShortDateFormat'), $input['date'])->format('Y-m-d');

    if($this->getAccountChildrenCount($input['id']) > 0 && $input['is_group'] == 0)
    {
      return json_encode(array('info' => $this->Lang->get('decima-accounting::account-management.isGroupException')));
    }

    $this->DB->transaction(function() use (&$input, $newParentAccount, $newAccountType, &$groupsAccounts, &$info)
		{
      $Account = $this->Account->byId($input['id']);
      $unchangedAccountValues = $Account->toArray();

      if(rtrim($input['key']) != rtrim($Account->key) && $this->Account->byOrganizationAndByKey($this->AuthenticationManager->getCurrentUserOrganizationId(), $input['key'])->count() > 0)
      {
        $info = $this->Lang->get('decima-accounting::account-management.keyValidationMessage', array('key' => $input['key']));
        return;
      }

      $this->Account->update($input, $Account);

      if(!empty($input['is_group']))
      {
        $groupsAccounts = $this->getGroupsAccounts();
      }

      $diff = 0;

      foreach ($input as $key => $value)
      {
        if($unchangedAccountValues[$key] != $value)
        {
          $diff++;

          if($diff == 1)
          {
            $Journal = $this->Journal->create(array('journalized_id' => $Account->id, 'journalized_type' => $this->Account->getTable(), 'user_id' => $this->AuthenticationManager->getLoggedUserId(), 'organization_id' => $this->AuthenticationManager->getCurrentUserOrganizationId()));
          }

          if($key == 'balance_type')
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::account-management.balanceType'), 'field_lang_key' => 'decima-accounting::account-management.balanceType', 'old_value' => $this->Lang->get('decima-accounting::account-management.' . $unchangedAccountValues[$key]), 'new_value' => $this->Lang->get('decima-accounting::account-management.' . $value)), $Journal);
          }
          else if ($key == 'account_type_id')
          {
            $oldAccountType = $this->AccountType->byId($unchangedAccountValues[$key]);
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::account-management.accountType'), 'field_lang_key' => 'decima-accounting::account-management.accountType', 'old_value' => $oldAccountType->name, 'new_value' => $newAccountType), $Journal);
          }
          else if ($key == 'parent_account_id')
          {
            if(!empty($unchangedAccountValues[$key]))
            {
              $OldParentAccount = $this->Account->byId($unchangedAccountValues[$key]);
              $oldParentAccount = $OldParentAccount->key . ' ' . $OldParentAccount->name;
            }
            else
            {
              $oldParentAccount = '';
            }

            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::account-management.parentAccount'), 'field_lang_key' => 'decima-accounting::account-management.parentAccount', 'old_value' => $oldParentAccount, 'new_value' => $newParentAccount), $Journal);
          }
          else if($key == 'is_group')
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::account-management.isGroupLong'), 'field_lang_key' => 'decima-accounting::account-management.isGroupLong', 'old_value' => $this->Lang->get('decima-accounting::account-management.' . $unchangedAccountValues[$key]), 'new_value' => $this->Lang->get('decima-accounting::account-management.' . $value)), $Journal);
          }
          else
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::account-management.' . camel_case($key)), 'field_lang_key' => 'decima-accounting::account-management.' . camel_case($key), 'old_value' => $unchangedAccountValues[$key], 'new_value' => $value), $Journal);
          }
        }
      }
    });

    if(!$info)
    {
      return json_encode(array('success' => $this->Lang->get('form.defaultSuccessUpdateMessage'), 'groupsAccounts' => $groupsAccounts));
    }
    else
    {
      return json_encode(array('info' => $info));
    }
  }

  /**
   * Delete an existing account (soft delete)
   *
   * @param array $input
	 * 	An array as follows: array(id => $id);
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessDeleteMessage}
   */
  public function delete(array $input)
  {
    $info = false;

    $this->DB->transaction(function() use ($input, &$info)
    {
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');
      $ids = $this->getAccountChildrenIds($input['id']);

      array_push($ids, $input['id']);

      if($this->JournalEntry->byAccountIds($ids)->count() > 0)
      {
        $info = $this->Lang->get('decima-accounting::account-management.accountValidationMessage');
        return;
      }

      $this->Account->byIds($ids)->each(function($Account) use ($loggedUserId, $organizationId)
      {
        $Journal = $this->Journal->create(array('journalized_id' => $Account->id, 'journalized_type' => $this->Account->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::account-management.accountDeletedAccount', array('account' => $Account->key . ' ' . $Account->name)), $Journal));
      });

      $this->Account->delete($ids);
    });

    if(!$info)
    {
      return json_encode(array('success' => $this->Lang->get('form.defaultSuccessDeleteMessage')));
    }
    else
    {
      return json_encode(array('info' => $info));
    }
  }


  /**
   * Get accounts children
   *
   * @param int $id
   *
   * @return array
   *  An array of arrays as follows: array( $id0, $id1,…)
   */
  public function getAccountChildrenIds($id)
  {
    $ids = array();

    $this->Account->byParent($id)->each(function($Account) use (&$ids)
    {
      if($Account->is_group)
      {
        $ids = array_merge($ids, $this->getAccountChildrenIds($Account->id));
      }

      array_push($ids, $Account->id);
    });

    return $ids;
  }

  /**
   * Get accounts children count
   *
   * @param int $id
   *
   * @return int
   */
  public function getAccountChildrenCount($id)
  {
    return $this->Account->byParent($id)->count();
  }

  /**
   * Get accounts children
   *
   * @param array $input
	 * 	An array as follows: array(id => $id);
   *
   * @return JSON encoded string
   *  A string as follows: [{"text" : $accountKey . " " . $accountName, "state" : {"opened" : true }, "icon" : $icon, "children" : [{"text" : $childAccountKey0 . " " . $childAccountName0, "icon" : $childIcon0}, …]}]
   */
  public function getAccountChildren($input)
  {
    $Account = $this->Account->byId($input['id']);

    $AccountType = $this->AccountType->byId($Account->account_type_id);

    $accountTree = array('text' => $Account->key . ' ' . $Account->name, 'state' => array('opened' => true), 'icon' => 'fa fa-sitemap', 'children' => array());

    $this->Account->byParent($input['id'])->each(function($Account) use (&$accountTree)
    {
      if($Account->is_group)
      {
        array_push($accountTree['children'], array('text' => $Account->key . ' ' . $Account->name, 'icon' => 'fa fa-sitemap'));
      }
      else
      {
        array_push($accountTree['children'], array('text' => $Account->key . ' ' . $Account->name, 'icon' => 'fa fa-leaf'));
      }
    });

    // return array(array('label' => $this->Lang->get('decima-accounting::account-management.D'), 'value'=> 'D'), array('label' => $this->Lang->get('decima-accounting::account-management.A'), 'value'=> 'A'));
    // $this->AccountType->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($AccountType) use (&$accountTypes)
    // {
    // array_push($accountTypes, array('label'=> $AccountType->name, 'value'=>$AccountType->id));
    // });
    return json_encode(array('accountTree' => $accountTree, 'balanceTypeName' => $this->Lang->get('decima-accounting::account-management.' . $Account->balance_type), 'balanceTypeValue' => $Account->balance_type, 'accountTypeName' => $AccountType->name, 'accountTypeValue' => $Account->account_type_id));
  }
}

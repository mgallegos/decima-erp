<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\Account;

use Illuminate\Database\Eloquent\Model;

use Mgallegos\DecimaAccounting\Accounting\Account;

class EloquentAccount implements AccountInterface {

  /**
   * Account
   *
   * @var Mgallegos\DecimaAccounting\Accounting\Account
   *
   */
  protected $Account;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $Account, $databaseConnectionName)
  {
      $this->Account = $Account;

      $this->databaseConnectionName = $databaseConnectionName;

      $this->Account->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->Account->getTable();
  }

  /**
   * Get an account by ID
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\Account
   */
  public function byId($id)
  {
  	return $this->Account->on($this->databaseConnectionName)->find($id);
  }

  /**
   * Get an account by ID's
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\Account
   */
  public function byIds(array $ids)
  {
  	return $this->Account->whereIn('id',$ids)->get();
  }

  /**
   * Retrieve accounts by organization
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganization($id)
  {
    return $this->Account->where('organization_id', '=', $id)->get();
  }

  /**
   * Retrieve accounts by organization and by key
   *
   * @param  int $organizationId
   * @param  string $key
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganizationAndByKey($organizationId, $key)
  {
    return $this->Account->where('organization_id', '=', $organizationId)->where('key', '=', $key)->get();
  }

  /**
   * Retrieve accounts by parent
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byParent($id)
  {
    return $this->Account->where('parent_account_id', '=', $id)->get();
  }

  /**
   * Create a new account
   *
   * @param array $data
   * 	An array as follows: array('name'=>$name, 'key'=>$key, 'balance_type'=>$balanceType,
   *                              'account_type_id'=>$accountTypeId, 'parent_account_id' => $parentAccountId, 'organization_id'=>$organizationId
   *                            );
   *
   * @return boolean
   */
  public function create(array $data)
  {
    $Account = new Account();
    $Account->setConnection($this->databaseConnectionName);
    $Account->fill($data)->save();

    return $Account;
  }

  /**
   * Update an existing account
   *
   * @param array $data
   * 	An array as follows: array('name'=>$name, 'key'=>$key, 'balance_type'=>$balanceType,
   *                              'account_type_id'=>$accountTypeId, 'parent_account_id' => $parentAccountId, 'organization_id'=>$organizationId
   *                            );
   *
   * @param Mgallegos\DecimaAccounting\Account $Account
   *
   * @return boolean
   */
  public function update(array $data, $Account = null)
  {
    if(empty($Account))
    {
      $Account = $this->byId($data['id']);
    }

    foreach ($data as $key => $value)
    {
      $Account->$key = $value;
    }

    return $Account->save();
  }

  /**
   * Delete existing account (soft delete)
   *
   * @param array $data
   * 	An array as follows: array($id0, $id1,…);
   * @return boolean
   */
  public function delete(array $data)
  {
    foreach ($data as $key => $id)
    {
      $Account = $this->byId($id);
      $Account->delete();
    }
    // $this->Account->destroy($data);
    
    return true;
  }

}

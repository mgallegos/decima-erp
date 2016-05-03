<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType;

use Illuminate\Database\Eloquent\Model;

use Mgallegos\DecimaAccounting\Accounting\AccountType;

class EloquentAccountType implements AccountTypeInterface {

  /**
   * AccountType
   *
   * @var Mgallegos\DecimaAccounting\Accounting\AccountType
   *
   */
  protected $AccountType;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $AccountType, $databaseConnectionName)
  {
      $this->AccountType = $AccountType;

      $this->databaseConnectionName = $databaseConnectionName;

      $this->AccountType->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->AccountType->getTable();
  }


  /**
   * Get an account type by ID
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\AccountType
   */
  public function byId($id)
  {
  	return $this->AccountType->on($this->databaseConnectionName)->find($id);
  }

  /**
   * Retrieve accounts types by organization
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganization($id)
  {
    return $this->AccountType->where('organization_id', '=', $id)->get();
  }

  /**
   * Create a new account type
   *
   * @param array $data
   * 	An array as follows: array('name'=>$name, 'pl_bs_category'=>$plBsCategory, 'deferral_method'=>$deferralMethod,
   *                              'lang_key'=>$langKey, 'organization_id'=>$organizationId
   *                            );
   *
   * @return boolean
   */
  public function create(array $data)
  {
    $AccountType = new AccountType();
    $AccountType->setConnection($this->databaseConnectionName);
    $AccountType->fill($data)->save();

    return $AccountType;
  }

  /**
   * Update an existing account type
   *
   * @param array $data
   * 	An array as follows: array('name'=>$name, 'pl_bs_category'=>$plBsCategory, 'deferral_method'=>$deferralMethod,
   *                              'lang_key'=>$langKey, 'organization_id'=>$organizationId
   *                            );
   *
   * @param Mgallegos\DecimaAccounting\AccountType $AccountType
   *
   * @return boolean
   */
  public function update(array $data, $AccountType = null)
  {
    if(empty($AccountType))
    {
      $AccountType = $this->byId($data['id']);
    }

    foreach ($data as $key => $value)
    {
      $AccountType->$key = $value;
    }

    return $AccountType->save();
  }

}

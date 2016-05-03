<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\System\Repositories\Account;

use Illuminate\Database\Eloquent\Model;

class EloquentAccount implements AccountInterface {

  /**
  * Account Model
  *
  * @var Mgallegos\DecimaAccounting\System\Account
  *
  */
  protected $Account;

  // Class expects an Eloquent model
  public function __construct(Model $Account)
  {
      $this->Account = $Account;
  }

  /**
  * Retrieve system account by id
  *
  * @param  int $id
  *
  * @return Mgallegos\DecimaAccounting\System\Account
  */
  public function byId($id)
  {
    return $this->Account->find($id);
  }

  /**
   * Get all accounts
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function all()
  {
  	return $this->Account->all();
  }

  /**
  * Retrieve accounts by account chart type
  *
  * @param  int $id account chart type id
  *
  * @return Illuminate\Database\Eloquent\Collection
  */
  public function accountsByAccountChartsTypes($id)
  {
    return $this->Account->where('account_chart_type_id', '=', $id)->orderBy('id', 'asc')->get();
  }
}

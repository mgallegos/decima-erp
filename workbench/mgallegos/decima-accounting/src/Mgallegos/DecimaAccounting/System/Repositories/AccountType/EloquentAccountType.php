<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\System\Repositories\AccountType;

use Illuminate\Database\Eloquent\Model;

class EloquentAccountType implements AccountTypeInterface {

  /**
  * Account Type Model
  *
  * @var Mgallegos\DecimaAccounting\System\AccountType
  *
  */
  protected $AccountType;

  // Class expects an Eloquent model
  public function __construct(Model $AccountType)
  {
      $this->AccountType = $AccountType;
  }

 /**
  * Retrieve system account type by id
  *
  * @param  int $id
  *
  * @return Mgallegos\DecimaAccounting\System\AccountType
  */
  public function byId($id)
  {
    return $this->AccountType->find($id);
  }

  /**
   * Get all system accounts types
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function all()
  {
  	return $this->AccountType->all();
  }
}

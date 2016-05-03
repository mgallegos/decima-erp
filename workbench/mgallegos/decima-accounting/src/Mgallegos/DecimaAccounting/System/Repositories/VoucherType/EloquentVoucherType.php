<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\System\Repositories\VoucherType;

use Illuminate\Database\Eloquent\Model;

class EloquentVoucherType implements VoucherTypeInterface {

  /**
  * Account Type Model
  *
  * @var Mgallegos\DecimaAccounting\System\VoucherType
  *
  */
  protected $VoucherType;

  // Class expects an Eloquent model
  public function __construct(Model $VoucherType)
  {
      $this->VoucherType = $VoucherType;
  }

 /**
  * Retrieve system account type by id
  *
  * @param  int $id
  *
  * @return Mgallegos\DecimaAccounting\System\VoucherType
  */
  public function byId($id)
  {
    return $this->VoucherType->find($id);
  }

  /**
   * Get all system accounts types
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function all()
  {
  	return $this->VoucherType->all();
  }
}

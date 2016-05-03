<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\System\Repositories\VoucherType;

interface VoucherTypeInterface {

  /**
  * Retrieve system account type by id
  *
  * @param  int $id
  *
  * @return Mgallegos\DecimaAccounting\System\VoucherType
  */
  public function byId($id);

 /**
  * Get all system accounts types
  *
  * @return Illuminate\Database\Eloquent\Collection
  */
  public function all();

}

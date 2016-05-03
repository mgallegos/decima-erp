<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\System\Repositories\AccountChartType;

interface AccountChartTypeInterface {

  /**
  * Retrieve system account by id
  *
  * @param  int $id
  *
  * @return Mgallegos\DecimaAccounting\System\AccountChartType
  */
  public function byId($id);

  /**
  * Get all accounts
  *
  * @return Illuminate\Database\Eloquent\Collection
  */
  public function all();

  /**
  * Retrieve accounts charts types by country
  *
  * @param  array $id countries id
  *
  * @return Illuminate\Database\Eloquent\Collection
  */
  public function accountsChartsTypesByCountry($id);

}

<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\System\Repositories\Currency;

interface CurrencyInterface {

 /**
  * Retrieve currency by id
  *
  * @param  int $id
  *
  * @return App\Kwaai\System\Currency
  */
  public function byId($id);

 /**
  * Retrieve currencies by id
  *
  * @param  array $ids currencies id
  *
  * @return App\Kwaai\System\Currency
  */
  public function currenciesById($ids);

  /**
   * Get all currencies
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function all();

}

<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\System\Repositories\Currency;

use Illuminate\Database\Eloquent\Model;

class EloquentCurrency implements CurrencyInterface {

  /**
  * Currency Model
  *
  * @var App\Kwaai\System\Currency
  *
  */
  protected $Currency;

  // Class expects an Eloquent model
  public function __construct(Model $Currency)
  {
      $this->Currency = $Currency;
  }

  /**
  * Retrieve currency by id
  *
  * @param  int $id
  *
  * @return App\Kwaai\System\Currency
  */
  public function byId($id)
  {
    return $this->Currency->find($id);
  }

  /**
  * Retrieve currencies by id
  *
  * @param  array $ids currencies id
  *
  * @return App\Kwaai\System\Currency
  */
  public function currenciesById($ids)
  {
    return $this->Currency->whereIn('id', $ids)->get();
  }

  /**
   * Get all currencies
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function all()
  {
  	return $this->Currency->all();
  }
}

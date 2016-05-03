<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\System\Repositories\Country;

use Illuminate\Database\Eloquent\Model;

class EloquentCountry implements CountryInterface {

  /**
  * Country Model
  *
  * @var App\Kwaai\System\Country
  *
  */
  protected $Country;

  // Class expects an Eloquent model
  public function __construct(Model $Country)
  {
      $this->Country = $Country;
  }

  /**
  * Retrieve country by id
  *
  * @param  int $id
  *
  * @return App\Kwaai\System\Country
  */
  public function byId($id)
  {
    return $this->Country->find($id);
  }

  /**
  * Retrieve countries by id
  *
  * @param  array $ids countries id
  *
  * @return App\Kwaai\System\Country
  */
  public function countriesById($ids)
  {
    return $this->Country->whereIn('id', $ids)->get();
  }

  /**
   * Get all countries
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function all()
  {
  	return $this->Country->all();
  }
}

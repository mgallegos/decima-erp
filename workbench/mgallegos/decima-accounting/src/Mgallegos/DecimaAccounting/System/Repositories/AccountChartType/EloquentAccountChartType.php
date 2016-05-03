<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\System\Repositories\AccountChartType;

use Illuminate\Database\Eloquent\Model;

class EloquentAccountChartType implements AccountChartTypeInterface {

  /**
  * Account Chart Type Model
  *
  * @var Mgallegos\DecimaAccounting\System\AccountChartType
  *
  */
  protected $AccountChartType;

  // Class expects an Eloquent model
  public function __construct(Model $AccountChartType)
  {
      $this->AccountChartType = $AccountChartType;
  }

  /**
  * Retrieve AccountChartType by id
  *
  * @param  int $id
  *
  * @return Mgallegos\DecimaAccounting\System\AccountChartType
  */
  public function byId($id)
  {
    return $this->AccountChartType->find($id);
  }

  /**
   * Get all accounts charts types
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function all()
  {
  	return $this->AccountChartType->all();
  }

  /**
  * Retrieve accounts charts types by country
  *
  * @param  array $id countries id
  *
  * @return Illuminate\Database\Eloquent\Collection
  */
  public function accountsChartsTypesByCountry($id)
  {
    return $this->AccountChartType->where(function($query) use ($id)
      {
        $query->orWhere('country_id', '=', $id);
        $query->orWhereNull('country_id');
      })->get();
  }
}

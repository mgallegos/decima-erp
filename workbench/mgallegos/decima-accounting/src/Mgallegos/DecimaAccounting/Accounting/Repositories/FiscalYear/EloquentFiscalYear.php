<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear;

use Illuminate\Database\Eloquent\Model;

class EloquentFiscalYear implements FiscalYearInterface {

  /**
   * FiscalYear
   *
   * @var Mgallegos\DecimaAccounting\Accounting\FiscalYear
   *
   */
  protected $FiscalYear;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $FiscalYear, $databaseConnectionName)
  {
      $this->FiscalYear = $FiscalYear;

      $this->databaseConnectionName = $databaseConnectionName;

      $this->FiscalYear->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->FiscalYear->getTable();
  }

  /**
   * Get an fiscal year by ID
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\FiscalYear
   */
  public function byId($id)
  {
  	return $this->FiscalYear->on($this->databaseConnectionName)->find($id);
  }

  /**
   * Retrieve fiscal years by organization
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganization($id)
  {
    return $this->FiscalYear->where('organization_id', '=', $id)->orderBy('year', 'desc')->get();
  }

  /**
   * Retrieve fiscal year by year and by organization
   *
   * @param  int $id Organization id
   *
   * @return Mgallegos\DecimaAccounting\FiscalYear
   */
  public function byYearAndByOrganization($year, $organiztionId)
  {
    return $this->FiscalYear->where('year', '=', $year)->where('organization_id', '=', $organiztionId)->get()->first();
  }

  /**
   * Retrieve last fiscal years by organization
   *
   * @param  int $id Organization id
   *
   * @return int Fiscal year id
   */
  public function lastFiscalYearByOrganization($id)
  {
    return $this->FiscalYear->where('organization_id', '=', $id)->max('id');
  }

  /**
   * Create a new fiscal year
   *
   * @param array $data
   * 	An array as follows: array('year'=>$year, 'start_date'=>$startDate, 'end_date'=>$endDate,
   *                              'is_closed'=>$isClosed, 'organization_id'=>$organizationId
   *                            );
   *
   * @return boolean
   */
  public function create(array $data)
  {
    $this->FiscalYear->fill($data)->save();

    return $this->FiscalYear;
  }

  /**
   * Update an existing fiscal year
   *
   * @param array $data
   * 	An array as follows: array('year'=>$year, 'start_date'=>$startDate, 'end_date'=>$endDate,
   *                              'is_closed'=>$isClosed, 'organization_id'=>$organizationId
   *                            );
   *
   * @param Mgallegos\DecimaAccounting\FiscalYear $FiscalYear
   *
   * @return boolean
   */
  public function update(array $data, $FiscalYear = null)
  {
    if(empty($FiscalYear))
    {
      $FiscalYear = $this->byId($data['id']);
    }

    foreach ($data as $key => $value)
    {
      $FiscalYear->$key = $value;
    }

    return $FiscalYear->save();
  }

}

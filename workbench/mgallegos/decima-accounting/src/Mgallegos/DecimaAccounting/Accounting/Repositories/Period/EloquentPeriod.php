<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\Period;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\DatabaseManager;

use Mgallegos\DecimaAccounting\Accounting\Period;

class EloquentPeriod implements PeriodInterface {

  /**
   * Period
   *
   * @var Mgallegos\DecimaAccounting\Accounting\Period
   *
   */
  protected $Period;

  /**
   * DB
   *
   * @var Illuminate\Database\DatabaseManager
   *
   */
  protected $DB;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $Period, DatabaseManager $DB, $databaseConnectionName)
  {
      $this->Period = $Period;

      $this->DB = $DB;

      $this->databaseConnectionName = $databaseConnectionName;

      $this->Period->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->Period->getTable();
  }

  /**
   * Get period by ID
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\Period
   */
  public function byId($id)
  {
  	return $this->Period->on($this->databaseConnectionName)->find($id);
  }

  /**
   * Retrieve periods by organization
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganization($id)
  {
    return $this->Period->where('organization_id', '=', $id)->get();
  }

  /**
   * Retrieve periods by organization with its year
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganizationWithYear($id)
  {
    return $this->Period->where('organization_id', '=', $id)->with('year')->get();
  }

  /**
   * Get last period by organization and by fiscal year
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function lastPeriodbyOrganizationAndByFiscalYear($organizationId, $fiscalYearId)
  {
    $Period = $this->Period->selectRaw('id, end_date, max(month) as month')
                ->where('organization_id', '=', $organizationId)
                ->where('fiscal_year_id', '=', $fiscalYearId)
                ->orderBy('month', 'desc')
                ->groupBy(array('id', 'end_date'))
                ->first();

    return $Period;
  }

  /**
   * Get first period by organization and by fiscal year
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function firstPeriodbyOrganizationAndByFiscalYear($organizationId, $fiscalYearId)
  {
    $Period = $this->Period->selectRaw('id, end_date, min(month) as month')
                ->where('organization_id', '=', $organizationId)
                ->where('fiscal_year_id', '=', $fiscalYearId)
                ->orderBy('month', 'asc')
                ->groupBy(array('id', 'end_date'))
                ->first();

    return $Period;
  }

  /**
   * Create a new period
   *
   * @param array $data
   * 	An array as follows: array('month'=>$month, 'start_date'=>$startDate, 'end_date'=>$endDate,
   *                              'is_closed'=>$isClosed, 'fiscal_year_id' => $fiscalYearId, 'organization_id'=>$organizationId
   *                            );
   *
   * @return boolean
   */
  public function create(array $data)
  {
    $Period = new Period();
    $Period->setConnection($this->databaseConnectionName);
    $Period->fill($data)->save();

    return $Period;
  }

  /**
   * Update an existing period
   *
   * @param array $data
   * 	An array as follows: array('month'=>$month, 'start_date'=>$startDate, 'end_date'=>$endDate,
   *                              'is_closed'=>$isClosed, 'fiscal_year_id' => $fiscalYearId, 'organization_id'=>$organizationId
   *                            );
   *
   * @param Mgallegos\DecimaAccounting\Period $Period
   *
   * @return boolean
   */
  public function update(array $data, $Period = null)
  {
    if(empty($Period))
    {
      $Period = $this->byId($data['id']);
    }

    foreach ($data as $key => $value)
    {
      $Period->$key = $value;
    }

    return $Period->save();
  }

}

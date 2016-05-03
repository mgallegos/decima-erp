<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\Setting;

use Illuminate\Database\Eloquent\Model;

class EloquentSetting implements SettingInterface {

  /**
   * Setting
   *
   * @var Mgallegos\DecimaAccounting\Accounting\Setting
   *
   */
  protected $Setting;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $Setting, $databaseConnectionName)
  {
      $this->Setting = $Setting;

      $this->databaseConnectionName = $databaseConnectionName;

      $this->Setting->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->Setting->getTable();
  }


  /**
   * Get set of settings by ID
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\Setting
   */
  public function byId($id)
  {
  	return $this->Setting->on($this->databaseConnectionName)->find($id);
  }

  /**
   * Get set of settings by organization
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganization($id)
  {
    return $this->Setting->where('organization_id', '=', $id)->get();
  }

  /**
   * Create a new set of settings
   *
   * @param array $data
   * 	An array as follows: array('initial_year'=>$initialYear, 'create_opening_period'=>$createOpeningPeriod, 'create_closing_period'=>$createClosingPeriod, 'is_configured'=>$isConfigured,
   *                              'currency_id'=>$currencyId, 'account_chart_type_id'=>$accountChartTypeId, 'organization_id'=>$organizationId
   *                            );
   *
   * @return Mgallegos\DecimaAccounting\Setting
   */
  public function create(array $data)
  {
    $this->Setting->fill($data)->save();

    return $this->Setting;
  }

  /**
   * Update an existing set of settings
   *
   * @param array $data
   * 	An array as follows: array('initial_year'=>$initialYear, 'create_opening_period'=>$createOpeningPeriod, 'create_closing_period'=>$createClosingPeriod, 'is_configured'=>$isConfigured,
   *                              'currency_id'=>$currencyId, 'account_chart_type_id'=>$accountChartTypeId, 'organization_id'=>$organizationId
   *                            );
   *
   * @param Mgallegos\DecimaAccounting\Setting $Setting
   *
   * @return Mgallegos\DecimaAccounting\Setting
   */
  public function update(array $data, $Setting = null)
  {
    if(empty($Setting))
    {
      $Setting = $this->byId($data['id']);
    }

    foreach ($data as $key => $value)
    {
      $Setting->$key = $value;
    }

    $Setting->save();

    return $Setting;
  }

  /**
   * Change database connection
   *
   * @param string $databaseConnectionName
   *
   * @return void
   */
  public function changeDatabaseConnection($databaseConnectionName)
  {
    $this->databaseConnectionName = $databaseConnectionName;

    $this->Setting->setConnection($databaseConnectionName);
  }


}

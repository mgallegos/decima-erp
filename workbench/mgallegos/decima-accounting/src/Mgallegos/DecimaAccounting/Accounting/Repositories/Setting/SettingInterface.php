<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\Setting;

interface SettingInterface {

	/**
	* Get table name
	*
	* @return string
	*/
	public function getTable();

	/**
	* Get set of settings by ID
	*
	* @param  int $id
	*
	* @return Mgallegos\DecimaAccounting\Setting
	*/
	public function byId($id);

	/**
	* Get set of settings by organization
	*
	* @param  int $id Organization id
	*
	* @return Illuminate\Database\Eloquent\Collection
	*/
	public function byOrganization($id);

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
	public function create(array $data);

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
	* @return boolean
	*/
	public function update(array $data, $Setting = null);

	/**
	* Change database connection
	*
	* @param string $databaseConnectionName
	*
	* @return void
	*/
	public function changeDatabaseConnection($databaseConnectionName);

}

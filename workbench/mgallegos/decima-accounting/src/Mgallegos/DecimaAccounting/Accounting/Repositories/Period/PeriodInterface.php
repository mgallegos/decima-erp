<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\Period;

interface PeriodInterface {

	/**
	* Get table name
	*
	* @return string
	*/
	public function getTable();

	/**
	* Get an account type by ID
	*
	* @param  int $id
	*
	* @return Mgallegos\DecimaAccounting\Period
	*/
	public function byId($id);

	/**
	* Create a new period
	*
	* @param array $data
	* 	An array as follows: array('month'=>$month, 'start_date'=>$startDate, 'end_date'=>$endDate,
	*                              'is_closed'=>$isClosed, 'fiscal_year_id' => $fiscalYearId, 'organization_id'=>$organizationId
	*                            );
	*
	* @return Mgallegos\DecimaAccounting\Period
	*/
	public function create(array $data);

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
	public function update(array $data, $Period = null);


}

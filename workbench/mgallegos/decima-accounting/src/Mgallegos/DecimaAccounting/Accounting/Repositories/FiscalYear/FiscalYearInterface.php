<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear;

interface FiscalYearInterface {


	/**
	* Get table name
	*
	* @return string
	*/
	public function getTable();

	/**
	* Get an fiscal year by ID
	*
	* @param  int $id
	*
	* @return Mgallegos\DecimaAccounting\FiscalYear
	*/
	public function byId($id);

	/**
	* Create a new fiscal year
	*
	* @param array $data
	* 	An array as follows: array('year'=>$year, 'start_date'=>$startDate, 'end_date'=>$endDate,
	*                              'is_closed'=>$isClosed, 'organization_id'=>$organizationId
	*                            );
	*
	* @return Mgallegos\DecimaAccounting\FiscalYear
	*/
	public function create(array $data);

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
	public function update(array $data, $FiscalYear = null);


}

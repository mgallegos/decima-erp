<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter;

interface CostCenterInterface {

	/**
	* Get table name
	*
	* @return string
	*/
	public function getTable();

	/**
	* Get a cost center by ID
	*
	* @param  int $id
	*
	* @return Mgallegos\DecimaAccounting\CostCenter
	*/
	public function byId($id);

	/**
	* Create a new cost center
	*
	* @param array $data
	* 	An array as follows: array('name'=>$name, 'key'=>$key, 'type'=>$type);
	*
	* @return boolean
	*/
	public function create(array $data);

	/**
	* Update an existing CostCenter
	*
	* @param array $data
	* 	An array as follows: array('name'=>$name, 'key'=>$key, 'type'=>$type);
	*
	* @param Mgallegos\DecimaAccounting\CostCenter $CostCenter
	*
	* @return boolean
	*/
	public function update(array $data, $CostCenter = null);


}

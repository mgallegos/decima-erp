<?php
/**
 * @file
 * Description of the script.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Vendor\DecimaModule\Module\Repositories\ModuleTableName;

interface ModuleTableNameInterface {

	/**
	* Get table name
	*
	* @return string
	*/
	public function getTable();

	/**
	* Get an account by ID
	*
	* @param  int $id
	*
	* @return Mgallegos\DecimaAccounting\Account
	*/
	public function byId($id);

	/**
   * Retrieve ... by organization
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganization($id)

	/**
   * Create a new ...
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1
   *                            );
   *
   * @return boolean
   */
	public function create(array $data);

	/**
   * Update an existing ...
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1
   *                            );
   *
   * @param Vendor\DecimaModule\Module\ModuleTableName $ModuleTableName
   *
   * @return boolean
   */
	public function update(array $data, $ModuleTableName = null);

	/**
   * Delete existing ... (soft delete)
   *
   * @param array $data
   * 	An array as follows: array($id0, $id1,…);
   * @return boolean
   */
  public function delete(array $data);


}

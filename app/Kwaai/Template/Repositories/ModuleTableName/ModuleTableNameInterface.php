<?php
/**
 * @file
 * Description of the script.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Template\Repositories\ModuleTableName;

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
	* Create a new account type
	*
	* @param array $data
	* 	An array as follows: array('name'=>$name, 'key'=>$key, 'balance_type'=>$balanceType,
	*                              'account_type_id'=>$accountTypeId, 'parent_account_id' => $parentAccountId, 'organization_id'=>$organizationId
	*                            );
	*
	* @return Mgallegos\DecimaAccounting\Account
	*/
	public function create(array $data);

	/**
	* Update an existing account type
	*
	* @param array $data
	* 	An array as follows: array('name'=>$name, 'key'=>$key, 'balance_type'=>$balanceType,
	*                              'account_type_id'=>$accountTypeId, 'parent_account_id' => $parentAccountId, 'organization_id'=>$organizationId
	*                            );
	*
	* @param Mgallegos\DecimaAccounting\Account $Account
	*
	* @return boolean
	*/
	public function update(array $data, $Account = null);


}

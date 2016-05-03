<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType;

interface AccountTypeInterface {

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
	* @return Mgallegos\DecimaAccounting\AccountType
	*/
	public function byId($id);

	/**
	* Create a new account type
	*
	* @param array $data
	* 	An array as follows: array('name'=>$name, 'pl_bs_category'=>$plBsCategory, 'deferral_method'=>$deferralMethod,
	*                              'lang_key'=>$langKey, 'organization_id'=>$organizationId
	*                            );
	*
	* @return Mgallegos\DecimaAccounting\AccountType
	*/
	public function create(array $data);

	/**
	* Update an existing account type
	*
	* @param array $data
	* 	An array as follows: array('name'=>$name, 'pl_bs_category'=>$plBsCategory, 'deferral_method'=>$deferralMethod,
	*                              'lang_key'=>$langKey, 'organization_id'=>$organizationId
	*                            );
	*
	* @param Mgallegos\DecimaAccounting\AccountType $AccountType
	*
	* @return boolean
	*/
	public function update(array $data, $AccountType = null);


}

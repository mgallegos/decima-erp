<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\VoucherType;

interface VoucherTypeInterface {

	/**
	* Get table name
	*
	* @return string
	*/
	public function getTable();

	/**
	* Get an Voucher type by ID
	*
	* @param  int $id
	*
	* @return Mgallegos\DecimaAccounting\VoucherType
	*/
	public function byId($id);

	/**
	* Create a new Voucher type
	*
	* @param array $data
	* 	An array as follows: array('name'=>$name, 'lang_key'=>$langKey, 'organization_id' => $organizationId);
	*
	* @return Mgallegos\DecimaAccounting\VoucherType
	*/
	public function create(array $data);

	/**
	* Update an existing Voucher type
	*
	* @param array $data
	* 	An array as follows: array('name'=>$name, 'lang_key'=>$langKey, 'organization_id' => $organizationId);
	*
	* @param Mgallegos\DecimaAccounting\VoucherType $VoucherType
	*
	* @return boolean
	*/
	public function update(array $data, $VoucherType = null);


}

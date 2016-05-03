<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher;

interface JournalVoucherInterface {

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
	* @return Mgallegos\DecimaAccounting\Accounting\JournalVoucher
	*/
	public function byId($id);

}

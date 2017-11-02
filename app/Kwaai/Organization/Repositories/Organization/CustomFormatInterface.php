<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Organization\Repositories\Organization;

interface CustomFormatInterface {

	/**
	 * Create a custom PDF format.
	 *
	 * @param array $data
	 *
	 * @return void
	 */
	public function run($data);
}

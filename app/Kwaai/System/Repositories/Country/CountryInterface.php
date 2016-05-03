<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\System\Repositories\Country;

interface CountryInterface {
	
	/**
     * Get all countries
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all();
		
}
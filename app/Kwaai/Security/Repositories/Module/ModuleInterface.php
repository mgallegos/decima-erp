<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\Module;

interface ModuleInterface {
	
	/**
	 * Get modules by ID
	 *
	 * @param  int $id
	 *
	 * @return App\Kwaai\Security\Module
	 */
	public function byId($id);
	
	/**
	 * Get all modules
	 * 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function all();
	    
    /**
     * Retrieve module's menus by module id
     *
     * @param  int $id Organization id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function menusByModule($id);
}
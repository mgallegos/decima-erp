<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\Module;

use Illuminate\Database\Eloquent\Model;

class EloquentModule implements ModuleInterface {

    protected $Module;

    // Class expects an Eloquent model
    public function __construct(Model $Module)
    {
        $this->Module = $Module;
    }
    
    /**
     * Get modules by ID
     * 
     * @param  int $id 
     *
     * @return App\Kwaai\Security\Module
     */
    public function byId($id)
    {
    	return $this->Module->find($id);
    }
    
    /**
     * Get all modules
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
    	return $this->Module->all();
    }
    
    /**
     * Retrieve module's menus by module id
     *
     * @param  int $id
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function menusByModule($id)
    {
    	return $this->Module->find($id)->menus;
    }
}
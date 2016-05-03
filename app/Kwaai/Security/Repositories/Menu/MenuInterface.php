<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\Menu;

interface MenuInterface {
		
	/**
     * Retrieve menus by menu id
     *
     * @param array $data
     * 	An array as follows: array($id0, $id,…);
     * @return Illuminate\Database\Eloquent\Collection
     */
	public function menusById(array $data);
	
	/**
	 * Retrieve menu by url
	 *
	 * @param string $url
	 * 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function menuByUrl($url);
	
	/**
     * Retrieve parent menus
     * @param int $moduleId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function parentMenusByModule($moduleId);
	    
    /**
     * Retrieve menu's permissions by menu id
     *
     * @param  int $id Menu id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function permissionsByMenu($id);
        
}
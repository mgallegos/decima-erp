<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\Menu;

use Illuminate\Database\Eloquent\Model;

class EloquentMenu implements MenuInterface {

    protected $Menu;

    // Class expects an Eloquent model
    public function __construct(Model $Menu)
    {
        $this->Menu = $Menu;
    }

    /**
     * Retrieve menus by menu id
     *
     * @param array $data
     * 	An array as follows: array($id0, $id,…);
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function menusById(array $data)
    {
    	return $this->Menu->whereIn('id', $data)->get();
    }

    /**
	 * Retrieve menu by url
	 *
	 * @param string $url
	 *
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function menuByUrl($url)
    {
    	return $this->Menu->where('url', '=', $url)->get();
    }

    /**
     * Retrieve parent menus
     * @param int $moduleId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function parentMenusByModule($moduleId)
    {
    	return $this->Menu->whereNull('url')->where('module_id', '=', $moduleId)->get();
    }

    /**
     * Retrieve menu's permissions by menu id
     *
     * @param  int $id Menu id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function permissionsByMenu($id)
    {
    	return $this->Menu->find($id)->permissions;
    }

}

<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\Permission;

use Illuminate\Database\Eloquent\Model;

class EloquentPermission implements PermissionInterface {

    protected $Permission;

    // Class expects an Eloquent model
    public function __construct(Model $Permission)
    {
        $this->Permission = $Permission;
    }

 /**
   * Retrieve permissions by permission id
   *
   * @param array $data
   * 	An array as follows: array($id0, $id,…);
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function permissionsById(array $data)
  {
  	return $this->Permission->whereIn('id', $data)->get();
  }

}

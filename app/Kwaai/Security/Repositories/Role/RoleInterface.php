<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\Role;

interface RoleInterface {

	/**
   * Retrieve system roles
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function roles();

	/**
     * Retrieve roles by Role id
     *
     * @param array $data
     * 	An array as follows: array($id0, $id,…);
     * @return Illuminate\Database\Eloquent\Collection
     */
	public function rolesById(array $data);

  /**
   * Retrieve menus's roles by role id
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function menusByRole($id);

}

<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\Role;

use Illuminate\Database\Eloquent\Model;

class EloquentRole implements RoleInterface {

  protected $Role;

  // Class expects an Eloquent model
  public function __construct(Model $Role)
  {
      $this->Role = $Role;
  }

  /**
   * Create a new journal
   *
   * @param array $data
   * 	An array as follows: array('name'=>$name, 'lang_key'=>$langKey, 'description'=>$description, 'description'=>$description, 'organization_id' => organizationId, 'created_by' => $createdBy)
   *
   * @return App\Kwaai\Security\Journal
   */
  public function create(array $data)
  {
    return $this->Role->create($data);
  }

  /**
   * Retrieve system roles
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function roles()
  {
  	return $this->Role->whereNull('organization_id')->get();
  }

  /**
   * Retrieve roles by Role id
   *
   * @param array $data
   * 	An array as follows: array($id0, $id,…);
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function rolesById(array $data)
  {
  	return $this->Role->whereIn('id', $data)->get();
  }

  /**
   * Retrieve menus's roles by role id
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function menusByRole($id)
  {
    return $this->Role->find($id)->menus;
  }

  /**
   * Attach roles to a user
   *
   * @param  int $roleId
   * @param  array $menusId
   * @param	int $createdBy
   * @param  App\Kwaai\Security\Role $Role
   *
   * @return boolean
   */
  public function attachMenus($roleId, $menusId, $createdBy, $Role = null)
  {
    if(empty($Role))
    {
      $Role = $this->Role->find($roleId);
    }

    foreach($menusId as $menuId)
    {
      $Role->menus()->attach($menuId, array('created_by' => $createdBy));
    }

    return true;
  }
}

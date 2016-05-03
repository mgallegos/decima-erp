<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\User;

interface UserInterface {

    /**
      * Get table name
      *
      * @return string
      */
     public function getTable();

    /**
     * Retrieve user by id
     *
     * @param  int $id User id
     *
     * @return App\Kwaai\Security\User
     */
    public function byId($id);

    /**
     * Retrieve user by email
     *
     * @param  string $email User email
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function byEmail($email);

    /**
     * Retrieve user's roles by user id
     *
     * @param  int $userId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function rolesByUserAndByOrganization($userId, $organizationId);

     /**
     * Retrieve user's menu options
     *
     * @param  int $userId
     * @param  int $moduleId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function menusByUserByModuleAndByOrganization($userId, $moduleId, $organizationId);

     /**
     * Retrieve user's menu options
     *
     * @param  int $userId
     * @param  int $moduleId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function menusByUserRolesByModuleAndByOrganization($userId, $moduleId, $organizationId);

    /**
     * Retrieve user's menu permissions
     *
     * @param  int $userId
     * @param  int $menuId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function permissionsByUserByMenuAndByOrganization($userId, $menuId, $organizationId);

    /**
     * Retrieve user's menu permissions
     *
     * @param  int $userId
     * @param  int $menuId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function  permissionsByUserRolesByMenuAndByOrganization($userId, $menuId, $organizationId);

    /**
     * Retrieve modules where user has access to at least one menu option.
     *
     * @param  int $userId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function modulesByUser($userId, $organizationId);

    /**
     * Retrieve user's organizations
     *
     * @param  int $id User id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function organizationByUser($id);

     /**
     * Create a new user
     *
     * @param array $data
     * 	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'timezone'=>$timezone, 'password'=>$password, 'is_active'=>$isActive, 'is_admin'=>$isAdmin, 'created_by'=>$createdBy, 'activation_code'=>$activationCode);
     *
     * @return App\Kwaai\Security\User
     */
    public function create(array $data);

    /**
     * Update an existing user
     *
     * @param array $data
     * 	An array as follows: array('id' => $id, 'firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'timezone'=>$timezone, 'password'=>$password, 'is_active'=>$isActive, 'created_by'=>$createdBy);
     * @param App\Kwaai\Security\User $User
     *
     * @return boolean
     */
    public function update(array $data, $User = null);

    /**
     * Restore a deleted user
     *
     * @param  int $id User id
     *
     * @return void
     */
    public function restore($id);

    /**
     * Delete existing users (soft delete)
     *
     * @param array $data
     * 	An array as follows: array($id0, $id1,…);
     *
     * @return boolean
     */
    public function delete(array $data);

    /**
     * Attach roles to a user
     *
     * @param  int $userId
     * @param  array $rolesId
     * @param	int $createdBy
     * @param  App\Kwaai\Security\User $User
     *
     * @return boolean
     */
    public function attachRoles($userId, $rolesId, $createdBy, $User = null);

    /**
     * Detach roles from a user
     *
     * @param  int $userId
     * @param  array $rolesId
     * @param  App\Kwaai\Security\User $User
     *
     * @return boolean
     */
    public function detachRoles($userId, $rolesId, $User = null);

    /**
     * Attach menus to a user
     *
     * @param  int $userId
     * @param  array $menusId
     * @param  boolean $selected
     * @param	int $organizationId
     * @param	int $createdBy
     * @param  App\Kwaai\Security\User $User
     *
     * @return boolean
     */
    public function attachMenus($userId, $menusId, $selected, $organizationId, $createdBy, $User = null);

    /**
     * Attach all menus to a user
     *
     * @param  int $userId
     * @param	int $organizationId
     * @param	int $createdBy
     *
     * @return boolean
     */
    public function attachAllMenus($userId, $organizationId, $createdBy);

    /**
     * Detach all menus of a user
     *
     * @param  int $userId
     * @param	int $organizationId
     *
     * @return int
     */
    public function detachAllMenus($userId, $organizationId);

    /**
     * Attach permissions to a user
     *
     * @param  int $userId
     * @param  array $permissionsId
     * @param  boolean $selected
     * @param	int $organizationId
     * @param	int $createdBy
     * @param  App\Kwaai\Security\User $User
     *
     * @return boolean
     */
    public function attachPermissions($userId, $permissionsId, $selected, $organizationId, $createdBy, $User = null);

    /**
     * Attach all permissions to a user
     *
     * @param  int $userId
     * @param	int $organizationId
     * @param	int $createdBy
     *
     * @return boolean
     */
    public function attachAllPermissions($userId, $organizationId, $createdBy);

    /**
     * Attach organizations to a user
     *
     * @param  int $userId
     * @param  array $organizationsId
     * @param  int $createdBy
     * @param  App\Kwaai\Security\User $User
     *
     * @return boolean
     */
    public function attachOrganizations($userId, $organizationsId, $createdBy, $User = null);

    /**
     * Detach organizations from a user
     *
     * @param  int $userId
     * @param  array $organizationsId
     * @param  App\Kwaai\Security\User $User
     *
     * @return boolean
     */
    public function detachOrganizations($userId, $organizationsId, $User = null);
}

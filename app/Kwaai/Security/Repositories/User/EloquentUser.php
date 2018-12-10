<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\User;

use Illuminate\Database\DatabaseManager;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\Model;


class EloquentUser implements UserInterface {

	/**
	 * User
	 *
	 * @var App\Kwaai\Security\User
	 *
	 */
    protected $User;

    /**
     * DB
     *
     * @var Illuminate\Database\DatabaseManager
     *
     */
    protected $DB;

    public function __construct(Model $User, DatabaseManager $DB)
    {
        $this->User = $User;

       	$this->DB = $DB;
    }

    /**
      * Get table name
      *
      * @return string
      */
     public function getTable()
     {
       return $this->User->getTable();
     }

	 /**
     * Retrieve user by id
     *
     * @param  int $id User id
     *
     * @return App\Kwaai\Security\User
     */
    public function byId($id)
    {
    	return $this->User->withTrashed()->find($id);
    }

    /**
     * Retrieve users by dynamic where
     *
     * @param  array $columns
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function byDynamicWhere(array $columns)
    {
    	$User = $this->User;

    	foreach ($columns as $column => $value)
    	{
    		$User = $User->where($column, '=', $value);
    	}

    	return $User->get();
    }

    /**
     * Retrieve user by email
     *
     * @param  string $email User email
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function byEmail($email)
    {
    	return $this->User->withTrashed()->where('email', '=', $email)->get();
    }

    /**
     * Retrieve user's roles
     *
     * @param  int $userId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function rolesByUser($userId, $organizationId)
    {
    	return $this->User->find($userId)->roles()->get();
    }

    /**
     * Retrieve user's roles
     *
     * @param  int $userId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function rolesByUserAndByOrganization($userId, $organizationId)
    {
    	return $this->User->find($userId)->roles()->where('SEC_User_Role.organization_id', '=', $organizationId)->get();
    	// return $this->User->find($userId)->roles()->where('pivot_organization_id', '=', $organizationId)->get();
    }

    /**
     * Retrieve user's menu options
     *
     * @param  int $userId
     * @param  int $moduleId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function menusByUserByModuleAndByOrganization($userId, $moduleId, $organizationId)
    {
    	return $this->User->find($userId)
							->menus()
							->where('module_id', '=', $moduleId)
							->where('organization_id', '=', $organizationId)
    					->get();
    }

    /**
     * Retrieve user's menu options
     *
     * @param  int $userId
     * @param  int $moduleId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function menusByUserRolesByModuleAndByOrganization($userId, $moduleId, $organizationId)
    {
  		$menus = $this->DB->table('SEC_Menu As m')
  			->join('SEC_Role_Menu AS rm', 'm.id', '=', 'rm.menu_id')
  			->where('m.module_id', '=', $moduleId)
  			->whereIn('rm.role_id', function($query) use ($userId, $organizationId)
  			{
          $query->select('ur.role_id')
            ->from('SEC_User_Role AS ur')
            //->join('SEC_Role AS r', 'r.id', '=', 'ur.role_id')
            ->where('ur.user_id', '=', $userId)
            ->where('ur.organization_id', '=', $organizationId);
  			})
  			->distinct()
  			->get(array('m.*'));

  		return new Collection($menus);

    }

    /**
     * Retrieve user's menu permissions
     *
     * @param  int $userId
     * @param  int $menuId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function permissionsByUserByMenuAndByOrganization($userId, $menuId, $organizationId)
    {
    	return $this->User->find($userId)
    						->permissions()
    						->where('menu_id', '=', $menuId)
    						->where('organization_id', '=', $organizationId)
    						->get();
    }

    /**
     * Retrieve user's menu permissions
     *
     * @param  int $userId
     * @param  int $menuId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function permissionsByUserRolesByMenuAndByOrganization($userId, $menuId, $organizationId)
    {
    	$permissions =  $this->DB->table('SEC_Permission As p')
						    	->join('SEC_Role_Permission AS rp', 'p.id', '=', 'rp.permission_id')
						    	->where('menu_id', '=', $menuId)
						    	->whereIn('rp.role_id', function($query) use ($userId, $organizationId)
						    	{
						    		$query->select('ur.role_id')
  										->from('SEC_User_Role AS ur')
  										->join('SEC_Role AS r', 'r.id', '=', 'ur.role_id')
  										->where('ur.user_id', '=', $userId)
  										->where('r.organization_id', '=', $organizationId);
						    	})
						    	->distinct()
						    	->get(array('p.id', 'p.name'));

      return new Collection($permissions);
    }

    /**
     * Retrieve modules where user has access to at least one menu option.
     *
     * @param  int $userId
     * @param  int $organizationId
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function modulesByUser($userId, $organizationId)
    {
		$modules =  $this->DB->table('SEC_Module As mo')
							->join('SEC_Menu AS me', 'mo.id', '=', 'me.module_id')
							->join('SEC_Role_Menu AS rm', 'me.id', '=', 'rm.menu_id')
							->whereIn('rm.role_id', function($query) use ($userId, $organizationId)
							{
								$query->select('ur.role_id')
										->from('SEC_User_Role AS ur')
										->join('SEC_Role AS r', 'r.id', '=', 'ur.role_id')
										->where('ur.user_id', '=', $userId)
										->where('r.organization_id', '=', $organizationId);
							})
							->distinct()
							->select('mo.id', 'mo.name', 'mo.lang_key', 'mo.icon');

		$modules =  $this->DB->table('SEC_Module As mo')
							->join('SEC_Menu AS me', 'mo.id', '=', 'me.module_id')
							->join('SEC_User_Menu AS um', 'me.id', '=', 'um.menu_id')
							->where('um.user_id', '=', $userId)
							->where('um.organization_id', '=', $organizationId)
							->where('um.is_assigned', '=', true)
							->union($modules)
							->distinct()
							->get(array('mo.id', 'mo.name', 'mo.lang_key', 'mo.icon'));

    	return new Collection($modules);
    }

    /**
     * Retrieve user's organizations
     *
     * @param  int $id User id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function organizationByUser($id)
    {
    	return $this->User->withTrashed()->find($id)->organizations;
    }

    /**
     * Retrieve user's organizations with exceptions
     *
     * @param  int $id User id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function organizationByUserWithExceptions($id, $organizationsExcludedIds)
    {
    	return $this->User->withTrashed()->find($id)->organizations()->whereNotIn('ORG_Organization.id', $organizationsExcludedIds)->get();
    }

     /**
     * Create a new user
     *
     * @param array $data
     * 	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'timezone'=>$timezone, 'password'=>$password, 'is_active'=>$isActive, 'is_admin'=>$isAdmin, 'created_by'=>$createdBy, 'activation_code'=>$activationCode);
     *
     * @return App\Kwaai\Security\User
     */
    public function create(array $data)
    {
    	return $this->User->create(array(
              'firstname' => $data['firstname'],
              'lastname' => $data['lastname'],
              'email' => $data['email'],
              'timezone' => $data['timezone'],
              'password' => $data['password'],
              'is_active' => $data['is_active'],
              'is_admin' => $data['is_admin'],
              'created_by' => $data['created_by'],
              'activation_code' => $data['activation_code'],
              'default_organization' => $data['default_organization'],
    			));
    }

    /**
     * Update an existing user
     *
     * @param array $data
     * 	An array as follows: array('id' => $id, 'firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'timezone'=>$timezone, 'password'=>$password, 'is_active'=>$isActive, 'created_by'=>$createdBy);
     * @param App\Kwaai\Security\User $User
     *
     * @return boolean
     */
    public function update(array $data, $User = null)
    {
      if(empty($User))
      {
        $User = $this->User->find($data['id']);
      }

    	foreach ($data as $key => $value)
    	{
    		$User->$key = $value;
    	}

    	if(!empty($input['password']))
    	{
    		$User->password = $data['password'];
    	}

    	return $User->save();
    }

    /**
     * Restore a deleted user
     *
     * @param  int $id User id
     *
     * @return void
     */
    public function restore($id)
    {
    	$this->DB->table('SEC_User')
        ->where('id', $id)
        ->update(array('is_active' => true, 'deleted_at' => null));
    }

    /**
     * Delete existing users (soft delete)
     *
     * @param array $data
     * 	An array as follows: array($id0, $id1,…);
     * @return boolean
     */
    public function delete(array $data)
    {
    	$this->User->destroy($data);

    	return true;
    }

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
    public function attachRoles($userId, $rolesId, $createdBy, $organizationId, $User = null)
    {
      if(empty($User))
      {
        $User = $this->User->find($userId);
      }

    	foreach($rolesId as $roleId)
    	{
    		$User->roles()->attach($roleId, array('created_by' => $createdBy, 'organization_id' => $organizationId));
    	}

    	return true;
    }

    /**
     * Detach roles from a user
     *
     * @param  int $userId
     * @param  array $rolesId
     * @param  App\Kwaai\Security\User $User
     *
     * @return boolean
     */
    public function detachRoles($userId, $rolesId, $User = null)
    {
      if(empty($User))
      {
        $User = $this->User->find($userId);
      }

    	foreach($rolesId as $roleId)
    	{
    		$User->roles()->detach($roleId);
    	}

    	return true;
    }

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
    public function attachMenus($userId, $menusId, $selected, $organizationId, $createdBy, $User = null)
    {
    	$this->DB->table('SEC_User_Menu')
			    	->where('user_id', '=', $userId)
			    	->whereIn('menu_id', $menusId)
			    	->where('organization_id', '=', $organizationId)
			    	->delete();

      if(empty($User))
      {
        $User = $this->User->find($userId);
      }

    	foreach($menusId as $menuId)
    	{
    		$User->menus()->attach($menuId, array('is_assigned'=>$selected, 'organization_id' => $organizationId, 'created_by' => $createdBy));
    	}

    	return true;
    }

    /**
     * Attach all menus to a user
     *
     * @param  int $userId
     * @param	int $organizationId
     * @param	int $createdBy
     *
     * @return boolean
     */
    public function attachAllMenus($userId, $organizationId, $createdBy)
    {
    	$rows = $this->DB->table('SEC_Menu')->whereNotNull('url')->get();

    	$menus = array();

    	foreach ($rows as $row)
    	{
    		array_push($menus, array('is_assigned' => true, 'user_id' => $userId, 'menu_id' => $row->id, 'organization_id' => $organizationId, 'created_by' => $createdBy, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')));
    	}

    	$this->DB->table('SEC_User_Menu')->insert( $menus );

    	return true;
    }

    /**
     * Detach all menus of a user
     *
     * @param  int $userId
     * @param	int $organizationId
     *
     * @return int
     */
    public function detachAllMenus($userId, $organizationId)
    {

       return $this->DB->table('SEC_User_Menu')
                ->where('user_id', '=', $userId)
                ->where('organization_id', '=', $organizationId)
                ->delete();
    }

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
    public function attachPermissions($userId, $permissionsId, $selected, $organizationId, $createdBy, $User = null)
    {
    	$this->DB->table('SEC_User_Permission')
			    	->where('user_id', '=', $userId)
			    	->whereIn('permission_id', $permissionsId)
			    	->where('organization_id', '=', $organizationId)
			    	->delete();

      if(empty($User))
      {
        $User = $this->User->find($userId);
      }

    	foreach($permissionsId as $permissionId)
    	{
    		$User->permissions()->attach($permissionId, array('is_assigned'=>$selected, 'organization_id' => $organizationId, 'created_by' => $createdBy));
    	}

    	return true;
    }

    /**
     * Attach all permissions to a user
     *
     * @param  int $userId
     * @param	int $organizationId
     * @param	int $createdBy
     *
     * @return boolean
     */
    public function attachAllPermissions($userId, $organizationId, $createdBy)
    {
    	$rows = $this->DB->table('SEC_Permission')->where('is_only_shortcut', '=', false)->get();

    	$permissions = array();

    	foreach ($rows as $row)
    	{
    		array_push($permissions, array('is_assigned' => true, 'user_id' => $userId, 'permission_id' => $row->id, 'organization_id' => $organizationId, 'created_by' => $createdBy, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')));
    	}

    	$this->DB->table('SEC_User_Permission')->insert( $permissions );

    	return true;
    }

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
    public function attachOrganizations($userId, $organizationsId, $createdBy, $User = null)
    {
      if(empty($User))
      {
        $User = $this->User->find($userId);
      }

    	foreach($organizationsId as $organizationId)
    	{
    		$User->organizations()->attach($organizationId, array('created_by' => $createdBy));
    	}

    	return true;
    }

    /**
     * Detach organizations from a user
     *
     * @param  int $userId
     * @param  array $organizationsId
     * @param  App\Kwaai\Security\User $User
     *
     * @return boolean
     */
    public function detachOrganizations($userId, $organizationsId, $User = null)
    {
    	if(empty($User))
      {
        $User = $this->User->find($userId);
      }

    	foreach($organizationsId as $organizationId)
    	{
    		$User->organizations()->detach($organizationId);
    	}

    	return true;
    }
}

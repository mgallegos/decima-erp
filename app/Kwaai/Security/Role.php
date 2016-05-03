<?php
/**
 * @file
 * Rol Model.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
namespace App\Kwaai\Security;

use Eloquent;

class Role extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'SEC_Role';

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = array('id');


	/**
	 * Many-to-many relation between SEC_Role and SEC_User
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany('App\Kwaai\Security\User', 'SEC_User_Role', 'role_id', 'user_id');
	}

	/**
	 * Many-to-many relation between SEC_Role and SEC_Permission
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function permissions()
	{
		return $this->belongsToMany('App\Kwaai\Security\Permission', 'SEC_Role_Permission', 'role_id', 'permission_id');
	}

	/**
	 * Many-to-many relation between SEC_Role and SEC_Menu
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function menus()
	{
		return $this->belongsToMany('App\Kwaai\Security\Menu', 'SEC_Role_Menu', 'role_id', 'menu_id');
	}

}

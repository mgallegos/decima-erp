<?php
/**
 * @file
 * Menu Model.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
namespace App\Kwaai\Security;

use Eloquent;

class Permission extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'SEC_Permission';
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = array('id');
	

	/**
	 * Many-to-many relation between SEC_Permission and SEC_User
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany('App\Kwaai\Security\User', 'SEC_User_Permission', 'permission_id', 'user_id');
	}
	
	/**
	 * Many-to-many relation between SEC_Permission and SEC_Roles
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles()
	{
		return $this->belongsToMany('App\Kwaai\Security\Role', 'SEC_Role_Permission', 'permission_id', 'role_id');
	}

}
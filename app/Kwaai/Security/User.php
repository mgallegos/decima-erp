<?php
/**
 * @file
 * User Model.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
namespace App\Kwaai\Security;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

	use Authenticatable, Authorizable, CanResetPassword, SoftDeletes;

	protected $dates = ['deleted_at'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'SEC_User';

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	 * Many-to-many relation between SEC_User and SEC_Role
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles()
	{
		return $this->belongsToMany('App\Kwaai\Security\Role', 'SEC_User_Role', 'user_id', 'role_id')->withTimestamps();
	}

	/**
	 * Many-to-many relation between SEC_User and SEC_Menu
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function menus()
	{
		return $this->belongsToMany('App\Kwaai\Security\Menu', 'SEC_User_Menu', 'user_id', 'menu_id')->withPivot('is_assigned')->withTimestamps();
	}

	/**
	 * Many-to-many relation between SEC_User and SEC_Permission
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function permissions()
	{
		return $this->belongsToMany('App\Kwaai\Security\Permission', 'SEC_User_Permission', 'user_id', 'permission_id')->withPivot('is_assigned')->withTimestamps();
	}

	/**
	 * Many-to-many relation between SEC_User and SEC_Organization
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function organizations()
	{
		return $this->belongsToMany('App\Kwaai\Organization\Organization', 'SEC_User_Organization', 'user_id', 'organization_id')->withTimestamps();
	}
}

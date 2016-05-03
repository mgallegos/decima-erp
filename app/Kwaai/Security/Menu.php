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

class Menu extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'SEC_Menu';

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 * Many-to-many relation between SEC_Menu and SEC_User
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany('App\Kwaai\Security\User', 'SEC_User_Menu', 'menu_id', 'user_id');
	}


	/**
	 * One-to-many relation between SEC_Menu and SEC_Permission
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function permissions()
	{
		return $this->hasMany('App\Kwaai\Security\Permission', 'menu_id', 'id');
	}

}

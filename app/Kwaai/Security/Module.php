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

class Module extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'SEC_Module';

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 * Has-many relation between SEC_module and SEC_Menu
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function menus()
	{
		return $this->hasMany('App\Kwaai\Security\Menu', 'module_id', 'id');
	}

}

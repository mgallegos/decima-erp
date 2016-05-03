<?php
/**
 * @file
 * Rol Model.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
namespace App\Kwaai\Organization;

use Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Eloquent {

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ORG_Organization';

	/**
	 * Indicates if the model should soft delete.
	 *
	 * @var bool
	 */
	protected $softDelete = true;

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 *  One-To-Many relation between ORG_Organization and SEC_Role
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\
	 */
	public function roles()
	{
		return $this->hasMany('App\Kwaai\Security\Role', 'organization_id', 'id');
	}

	/**
	 * Belongs-To relation between ORG_Organization and SYS_Country
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function country()
	{
		return $this->belongsTo('App\Kwaai\System\Country', 'country_id', 'id');
	}

	/**
	 * Many-to-many relation between SEC_User and SEC_Organization
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany('App\Kwaai\Security\User', 'SEC_User_Organization', 'organization_id', 'user_id')->withTimestamps()->withTrashed();
	}
}

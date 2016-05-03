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

class Journal extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'SEC_Journal';

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = array('id');


	/**
	 * One-to-many relation between SEC_Journal and SEC_Journal_Detail
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function details()
	{
		return $this->hasMany('App\Kwaai\Security\JournalDetail', 'journal_id', 'id');
	}

}

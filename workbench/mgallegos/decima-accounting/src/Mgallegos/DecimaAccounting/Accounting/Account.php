<?php
/**
 * @file
 * Currency Model.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
namespace Mgallegos\DecimaAccounting\Accounting;

use Illuminate\Database\Eloquent\SoftDeletes;

use Eloquent;

class Account extends Eloquent{

	use SoftDeletes;

  protected $dates = ['deleted_at'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ACCT_Account';

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = array('id');

}

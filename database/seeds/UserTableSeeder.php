<?php
/**
 * @file
 * SEC_User Table Seeder
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

use Illuminate\Database\Seeder;
use App\Kwaai\Security\User;


class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('SEC_User')->delete();

		User::create(array('firstname' => 'root', 'lastname' => 'root', 'email' => Config::get('system-security.root_default_email'), 'password' =>  Hash::make('root'), 'is_active' => true, 'is_admin' => true));
	}

}

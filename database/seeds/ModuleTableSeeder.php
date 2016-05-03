<?php
/**
 * @file
 * SEC_User Table Seeder
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

use Illuminate\Database\Seeder;
use App\Kwaai\Security\Module;

class ModuleTableSeeder extends Seeder {

	public function run()
	{
		DB::table('SEC_Module')->delete();

		Module::create(array('name' => 'General Setup', 'lang_key' => 'security/module.generalSetup', 'icon' => 'fa fa-cogs', 'created_by' => 1));//id: 1
	}

}

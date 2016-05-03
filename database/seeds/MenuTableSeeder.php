<?php
/**
 * @file
 * SEC_User Table Seeder
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

use Illuminate\Database\Seeder;
use App\Kwaai\Security\Menu;

class MenuTableSeeder extends Seeder {

	public function run()
	{
		DB::table('SEC_Menu')->delete();

		//General Setup Module
		Menu::create(array('name' => 'Organization', 'lang_key' => 'security/menu.organization', 'url' => null, 'icon' => 'fa fa-building-o', 'parent_id' => null, 'module_id' => 1, 'created_by' => 1));//id: 1
		Menu::create(array('name' => 'Organization Management', 'lang_key' => 'security/menu.organizationManagment', 'url' => '/general-setup/organization/organization-management', 'action_button_id' => 'om-btn-close', 'action_lang_key' => 'security/menu.organizationManagmentAction', 'icon' => 'fa fa-wrench', 'parent_id' => 1, 'module_id' => 1, 'created_by' => 1));//id: 2
		Menu::create(array('name' => 'Security', 'lang_key' => 'security/menu.security', 'url' => null, 'icon' => 'fa fa-lock', 'parent_id' => null, 'module_id' => 1, 'created_by' => 1));//id: 3
		Menu::create(array('name' => 'User Management', 'lang_key' => 'security/menu.userManagment', 'url' => '/general-setup/security/user-management', 'action_button_id' => 'um-btn-close', 'action_lang_key' => 'security/menu.userManagmentAction', 'icon' => 'fa fa-wrench', 'parent_id' => 3, 'module_id' => 1, 'created_by' => 1));//id: 4
	}

}

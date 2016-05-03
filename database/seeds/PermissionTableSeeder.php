<?php
/**
 * @file
 * SEC_User Table Seeder
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

use Illuminate\Database\Seeder;
use App\Kwaai\Security\Permission;

class PermissionTableSeeder extends Seeder {

	public function run()
	{
		DB::table('SEC_Permission')->delete();

		//Organization Management Permissions
		Permission::create(array('name' => 'Setup a new organization', 'key' => 'newOrganization', 'lang_key' => 'security/permission.newOrganization', 'url' => '/general-setup/organization/organization-management/new', 'alias_url' => '/general-setup/organization/organization-management', 'action_button_id' => 'om-btn-new', 'action_lang_key' => 'organization/organization-management.new', 'icon' => 'fa fa-plus', 'is_only_shortcut' => true, 'menu_id' => 2, 'created_by' => 1));//id: 1
		Permission::create(array('name' => 'Edit organization', 'key' => 'editOrganization', 'lang_key' => 'organization/organization-management.edit', 'url' => '/general-setup/organization/organization-management/edit', 'alias_url' => '/general-setup/organization/organization-management', 'action_button_id' => 'om-btn-edit-helper', 'action_lang_key' => 'organization/organization-management.edit', 'is_only_shortcut' => true, 'menu_id' => 2, 'created_by' => 1, 'hidden' => true));//id: 2
		Permission::create(array('name' => 'Remove organization', 'key' => 'removeOrganization', 'lang_key' => 'organization/organization-management.delete', 'url' => '/general-setup/organization/organization-management/remove', 'alias_url' => '/general-setup/organization/organization-management', 'action_button_id' => 'om-btn-remove-helper', 'action_lang_key' => 'organization/organization-management.delete', 'is_only_shortcut' => true, 'menu_id' => 2, 'created_by' => 1, 'hidden' => true));//id: 3
		//User Management Permissions
		Permission::create(array('name' => 'New user', 'key' => 'newUser', 'lang_key' => 'security/permission.newUser', 'url' => '/general-setup/security/user-management/new', 'alias_url' => '/general-setup/security/user-management', 'action_button_id' => 'um-btn-new', 'action_lang_key' => 'security/user-management.new', 'icon' => 'fa fa-plus', 'is_only_shortcut' => true, 'menu_id' => 4, 'created_by' => 1));//id: 4
		Permission::create(array('name' => 'New administrator user', 'key' => 'newAdminUser', 'lang_key' => 'security/permission.newAdminUser', 'url' => '/general-setup/security/user-management/new-admin', 'alias_url' => '/general-setup/security/user-management', 'action_button_id' => 'um-btn-new-admin', 'action_lang_key' => 'security/user-management.newAdminLongText', 'icon' => 'fa fa-plus', 'is_only_shortcut' => false, 'menu_id' => 4, 'created_by' => 1));//id: 5
		Permission::create(array('name' => 'Remove user', 'key' => 'removeUser', 'lang_key' => 'security/user-management.deleteLongText', 'url' => '/general-setup/security/user-management/remove-user', 'alias_url' => '/general-setup/security/user-management', 'action_button_id' => 'um-btn-remove-helper', 'action_lang_key' => 'security/user-management.deleteLongText', 'is_only_shortcut' => true, 'menu_id' => 4, 'created_by' => 1, 'hidden' => true));//id: 6
		Permission::create(array('name' => 'Assign role', 'key' => 'assignRole', 'lang_key' => 'security/permission.assignRole', 'url' => '/general-setup/security/user-management/assign-role', 'alias_url' => '/general-setup/security/user-management', 'action_button_id' => 'um-btn-assign-helper', 'action_lang_key' => 'security/permission.assignRole', 'is_only_shortcut' => true, 'menu_id' => 4, 'created_by' => 1, 'hidden' => true));//id: 7
		Permission::create(array('name' => 'Unassign role', 'key' => 'unassignRole', 'lang_key' => 'security/permission.unassignRole', 'url' => '/general-setup/security/user-management/unassign-role', 'alias_url' => '/general-setup/security/user-management', 'action_button_id' => 'um-btn-unassign-helper', 'action_lang_key' => 'security/permission.unassignRole', 'is_only_shortcut' => true, 'menu_id' => 4, 'created_by' => 1, 'hidden' => true));//id: 8
	}

}

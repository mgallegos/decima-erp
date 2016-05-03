<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Services\UserManagement;

interface UserManagementInterface {

	/**
	 * Create a new user.
	 *
	 * @param array $input
	 * 	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'password'=>$password, 'is_active'=>$is_active, 'is_locked'=>$is_locked);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessSaveMessage}
	 *  In case of failure: {"failure":form.defaultErrorMessage}
	 */
	public function save(array $input);

	/**
	 * Update an existing user.
	 *
	 * @param array $input
	 * 	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'password'=>$password, 'is_active'=>$is_active, 'is_locked'=>$is_locked);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessUpdateMessage}
	 *  In case of failure: {"failure":form.defaultErrorMessage}
	 */
	public function update(array $input);

	/**
	 * Update an existing user.
	 *
	 * @param array $input
	 *	An array as follows: array('multiple_organization_popover_shown'=>$multipleOrganizationPopoverShown, 'popovers_shown'=>$popoversShown);
	 *
	 * @return void
	*/
	public function updateloggedUserPopoverStatus(array $input);

	/**
	 * Delete existing users (soft delete).
	 *
	 * @param array $input
	 * 	An array as follows: array($id0, $id1,…);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessDeleteMessage}
	 *  In case of failure: {"failure":form.defaultErrorMessage}
	 */
	public function delete(array $input);

	/**
	 * Add existing user to an organization.
	 *
	 * @param array $input
	 *	An array as follows: array('id'=>$id);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessSaveMessage}
	 */
	public function addUserToOrganization(array $input);

	/**
	 * Set an existing user as an admin user.
	 *
	 * @param array $input
	 *	An array as follows: array('id'=>$id);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessSaveMessage}
	 */
	public function setUserAsAdmin(array $input);

	/**
	 * Set an existing user as an non-admin user (normal user).
	 *
	 * @param array $input
	 *	An array as follows: array('id'=>$id);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessSaveMessage}
	 */
	public function setUserAsNonAdmin(array $input);

	/**
	 * Set first organization available to user
	 *
	 * @param App\Kwaai\Security\User $User
	 * @param App\Kwaai\Security\Journal $Journal
	 * @param string $organizationName
	 *
	 * @return void
	 */
	public function setFirstOrganizationAvailableToUser($User, $Journal, $organizationName = null, $organizationsExcludedIds = array(-1));

	/**
	 * Deactivate user.
	 *
	 * @param App\Kwaai\Security\User $User
	 * @param App\Kwaai\Security\Journal $Journal
	 * @param string $organizationName
	 *
	 * @return void
	 */
	public function deactivateUser($User, $Journal, $organizationName = null);

	/**
	 * Save user roles.
	 *
	 * @param array $post
	 * 	An array as follows: array("rolesId" => array($id0, $id1), "selected" => true|false, "userId"=>$userId, "menuOptionModuleId"=>$menuOptionModuleId,"permissionsModuleId"=>$permissionsModuleId, "permissionsMenuId"=>$permissionsMenuId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  {
	 *  	userModuleMenus: [{label: $menuName0, value:$menuId0}, {label: $menuName1, value:$menuId1},…]
	 *  	userMenus: {$menuId0:$menuName0, $menuId1:$menuName1,…}
	 *  	permissionModuleMenus: [{label: $menuName0, value:$menuId0}, {label: $menuName1, value:$menuId1},…]
	 *  	menuPermissions: [{value:$permissionId0, text: $permissionName0}, {value:$permissionId0, text: $permissionName0},…]
	 *  	userPermissions: {$permissionId0:$permissionName0, $permissionId1:$permissionName1,…}
	 *  }
	 *
	 */
	public function saveRoles(array $post);

	/**
	 * Save user menus.
	 *
	 * @param array $post
	 * 	An array as follows: array("menusId" => array($id0, $id1), "selected" => true|false, "userId"=>$userId, "permissionsModuleId"=>$permissionsModuleId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  {
	 *  	permissionModuleMenus: [{label: $menuName0, value:$menuId0}, {label: $menuName1, value:$menuId1},…]
	 *  	menuPermissions: [{value:$permissionId0, text: $permissionName0}, {value:$permissionId0, text: $permissionName0},…]
	 *  	userPermissions: {$permissionId0:$permissionName0, $permissionId1:$permissionName1,…}
	 *  }
	 *
	 */
	public function saveMenus(array $post);

	/**
	 * Restore user menus to its original state.
	 *
	 * @param array $post
	 * 	An array as follows: array("userId"=>$userId, "menuOptionModuleId"=>$menuOptionModuleId,"permissionsModuleId"=>$permissionsModuleId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  {
	 *  	userModuleMenus: [{label: $menuName0, value:$menuId0}, {label: $menuName1, value:$menuId1},…]
	 *  	userMenus: {$menuId0:$menuName0, $menuId1:$menuName1,…}
	 *  	permissionModuleMenus: [{label: $menuName0, value:$menuId0}, {label: $menuName1, value:$menuId1},…]
	 *  	menuPermissions: [{value:$permissionId0, text: $permissionName0}, {value:$permissionId0, text: $permissionName0},…]
	 *  	userPermissions: {$permissionId0:$permissionName0, $permissionId1:$permissionName1,…}
	 *  }
	 *
	 */
	public function resetMenus(array $post);

	/**
	 * Save permissions menus.
	 *
	 * @param array $post
	 * 	An array as follows: array("permissionsId" => array($id0, $id1), "selected" => true|false, "userId"=>$userId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessSaveMessage}
	 *  In case of failure: {"failure":form.defaultErrorMessage}
	 */
	public function savePermissions(array $post);

	/**
	 * Get User roles, permissions, menu options, organization roles and system menu options.
	 *
	 * @param array $post
	 * 	An array as follows: array("userId"=>$userId, "menuOptionModuleId"=>$menuOptionModuleId,"permissionsModuleId"=>$permissionsModuleId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  {
	 *  	organizationRoles: [{value:$rolId0, text:$rolName0}, {value:$rolId1, text:$rolName1},…]
	 *  	userRoles: {$rolId0:$rolName0, $rolId1:$rolName1,…}
	 *  	userModuleMenus: [{label: $menuName0, value:$menuId0}, {label: $menuName1, value:$menuId1},…]
	 *  	userMenus: {$menuId0:$menuName0, $menuId1:$menuName1,…}
	 *  	permissionModuleMenus: [{label: $menuName0, value:$menuId0}, {label: $menuName1, value:$menuId1},…]
	 *  	menuPermissions: [{value:$permissionId0, text: $permissionName0}, {value:$permissionId0, text: $permissionName0},…]
	 *  	userPermissions: {$permissionId0:$permissionName0, $permissionId1:$permissionName1,…}
	 *  }
	 *
	 */
	public function getAccessControlList(array $post);

	/**
	 * Get user data by email.
	 *
	 * @param array $post
	 * 	An array as follows: array("email"=>$email);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  If user exist {question: security/user-management.questionToAssociateUser, userData: {id: $id, firstname: $firstname, lastname: $lastname}}
	 *  If user does not exist {userData: false}
	 */
	public function getUserByEmail(array $post);

	/**
	 * Get an specific column of a user by email.
	 *
	 * @param string $email
	 * @param string $email
	 *
	 * @return string
	 */
	public function getUserColumnByEmail($email, $columnName);

	/**
	 * Get non admin user data by email.
	 *
	 * @param array $post
	 * 	An array as follows: array("email"=>$email);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  If user exist and is not admin {question: security/user-management.questionToSetUserAsAdmin, userData: {id: $id, firstname: $firstname, lastname: $lastname}}
	 *  If user exist and is admin : {userAlreadyAdminException: security/user-management.userAlreadyInOrganizationException}
	 *  If user does not exist {userData: false}
	 */
	public function getNonAdminUserByEmail(array $post);

	/**
	 * Get user and module menus.
	 *
	 * @param array $post
	 * 	An array as follows: array("userId"=>$userId, "moduleId"=>$moduleId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  {
	 *  	userModuleMenus: [{label: $menuName0, value:$menuId0}, {label: $menuName1, value:$menuId1},…]
	 *  	userMenus: {$menuId0:$menuName0, $menuId1:$menuName1,…}
	 *  }
	 *
	 */
	public function getUserAndModuleMenus(array $post);

	/**
	 * Get user menus by module and menu permissions.
	 *
	 * @param array $post
	 * 	An array as follows: array("userId"=>$userId, "moduleId"=>$moduleId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  {
	 *  	permissionModuleMenus: [{label: $menuName0, value:$menuId0}, {label: $menuName1, value:$menuId1},…]
	 *  	menuPermissions: [{value:$permissionId0, text: $permissionName0}, {value:$permissionId0, text: $permissionName0},…]
	 *  	userPermissions: {$permissionId0:$permissionName0, $permissionId1:$permissionName1,…}
	 *  }
	 *
	 */
	public function getUserMenusByModuleAndMenuPermissions(array $post);

	/**
	 * Get user menus permissions by menu.
	 *
	 * @param array $post
	 * 	An array as follows: array("userId"=>$userId, "menuId"=>$menuId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  {
	 *  	menuPermissions: [{value:$permissionId0, text: $permissionName0}, {value:$permissionId0, text: $permissionName0},…]
	 *  	userPermissions: {$permissionId0:$permissionName0, $permissionId1:$permissionName1,…}
	 *  }
	 *
	 */
	public function getUserPermissionsByMenu(array $post);

	/**
	 * Get system modules.
	 *
	 * @return array
	 *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
	 */
	public function getSystemModules();

	/**
	 * Get timezones
	 *
	 * @return array
	 *  An array of arrays as follows: array($timezone1, $timezone2,…)
	 */
	public function getTimezones();

  /**
   * Get User Preferences Page Journals
   *
   * @return
   */
  public function getUserChangesJournals($id = null);

  /**
   * Get User Preferences Page Journals
   *
   * @return
   */
  public function getUserActionsJournals($id = null);

	/**
	 * Echo user grid data in a jqGrid compatible format.
	 *
	 * @param array $post
	 *	All jqGrid posted data
	 *
	 * @return void
	 */
	public function getUserGridData(array $post);

	/**
	 * Echo admin user grid data in a jqGrid compatible format.
	 *
	 * @param array $post
	 *	All jqGrid posted data
	 *
	 * @return void
	 */
	public function getAdminUserGridData(array $post);

	/**
	 * Get the number of organizations to which the user is associated.
	 *
	 * @param  int $id User id
	 *
	 * @return integer
	 */
	public function getCountUserOrganizations($id = null);

	/**
	 * Get fisrt organization to which the user is associated.
	 *
	 * @param  int $id User id
	 *
	 * @return array
	 */
	public function getFirstUserOrganizations($id = null, $organizationsExcludedIds);

	/**
	 * Get organizations to which the user is associated.
	 *
	 * @param  int $id User id
	 *
	 * @return array
	 */
	public function getUserOrganizations($id = null);

	/**
	* Get organizations to which the user is associated (autocomplete)
	*
	* @return array
	*  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
	*/
	public function getUserOrganizationsAutocomplete($id = null);

	/**
	 * Get all user apps and permissions shortcuts.
	 *
	 * @param  int $userId
	 * @param  int $menuId
	 * @param  int $organizationId
	 *
	 * @return array
	 *  An array of arrays as follows: array( array('label'=>$action, 'actionButtonId' => $actionButtonId, 'value'=>$appMenuLabel), array('label'=>$action, 'actionButtonId' => $actionButtonId, 'value'=>$appMenuLabel),…)
	 */
	public function getUserActions($userId = null, $organizationId = null);

	/**
	 * Get all permissions assigned to a user of an specific app.
	 *
	 * @param  int $userId
	 * @param  int $menuId
	 * @param  int $organizationId
	 *
	 * @return array
	 * 	An array of arrays as follows: array( $key0 => $name0, $key1 => $name1,…)
	 */
	public function getUserAppPermissions($userId = null, $menuId = null, $organizationId = null);


	/**
	 * Change logged user organization.
	 *
	 * @return void
	 */
	public function changeLoggedUserOrganization(array $input);

	/**
	 * Get user menu.
	 *
	 * @param array $post
	 * 	An array as follows: array("id"=>$userId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  [ { name: $moduleName, icon: $icon, childsMenus: [ { name: $menuName, url: $url, aliasUrl: $aliasUrl, actionButtonId: $actionButtonId, icon: $icon, hidden: $hidden, childsMenus: [ { … },… ] },… ] },…]
	 *
	 */
	public function getUserMenu(array $post);

	/**
	 * Build user menu.
	 *
	 * @param  int $userId
	 * @param  int $organizationId
	 * @param  int $returnArray
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  [ { name: $moduleName, icon: $icon, childsMenus: [ { name: $menuName, url: $url, aliasUrl: $aliasUrl, actionButtonId: $actionButtonId, icon: $icon, hidden: $hidden, childsMenus: [ { … },… ] },… ] },…]
	 *
	 */
	public function buildUserMenu($userId = null, $organizationId = null, $returnArray = false);
}

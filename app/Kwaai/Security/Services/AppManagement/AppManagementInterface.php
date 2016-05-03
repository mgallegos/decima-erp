<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Services\AppManagement;

interface AppManagementInterface {

	/**
	 * Get system name
	 *
	 * @return string
	 *
	 */
	public function getSystemName();

	/**
	* Get system icon
	*
	* @return string
	*
	*/
	public function getSystemIcon();

	/**
	* Get brand URL
	*
	* @return string
	*
	*/
	public function getBrandUrl();

	/**
	 * Get application information
	 *
	 * @return array
	 *  An array as follows: array('id'=>$id, 'url'=>$url, 'name'=>$name, 'breadcrumb'=>array($module, $subModule,…))
	 */
	public function getAppInfo();

	/**
	 * Get the login page URL.
	 *
	 * @return string
	 */
	public function getLoginPageUrl();

	/**
	 * Get the initial setup page URL.
	 *
	 * @return string
	 */
	public function getInitialSetupPageUrl();

	/**
	 * Get the user preference page URL.
	 *
	 * @return string
	 */
	public function getUserPreferencesPageUrl();

	/**
	 * Get the password reminder page URL.
	 *
	 * @return string
	 */
	public function getPasswordReminderPageUrl();

	/**
	 * Get the password reset page URL.
	 *
	 * @return string
	 */
	public function getPasswordResetPageUrl();

	/**
	 * Get the user activation page URL.
	 *
	 * @return string
	 */
	public function getUserActivationPageUrl();

	/**
	 * Get error page URL.
	 *
	 * @return string
	 */
	public function getErrorPageUrl();

	/**
	 * Get the Organization Management app URL.
	 *
	 * @return string
	 */
	public function getOrganizationManagementAppUrl();

	/**
	 * Get the Organization Management app URL.
	 *
	 * @return string
	 */
	public function getNewOrganizationManagementAppUrl();

	/**
	 * Verify if an user is trying to access the Organization Management app.
	 *
	 * @return boolean
	 */
	public function isOrganizationManagementApp();

	/**
	 * Verify if an user has access to an app.
	 *
	 * @param  int $userId
	 * @param  int $url
	 * @param  int $organizationId
	 *
	 * @return boolean
	 *  true if user has access, false otherwise.
	 */
	public function isUserClearToAccessApp($userId = null, $url = null, $organizationId = null);
}

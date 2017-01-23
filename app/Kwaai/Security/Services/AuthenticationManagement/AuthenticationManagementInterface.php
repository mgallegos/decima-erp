<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Services\AuthenticationManagement;

use App\Kwaai\Organization\Organization;

interface AuthenticationManagementInterface {

	/**
	 * User login authentication attempt
	 *
	 * @param string $email
	 * 	User email
	 * @param string $password
	 * 	User password
	 * @param  string $rememberMe
	 * 	"1" if the user wants to be "remember" by the application, null otherwise.
	 * @param  string $intendedUrl
	 * 	URL to redirect the user after login.
	 * @param array $input
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"message":"success","url":"$url"}
	 *  In case of failure: {"message":"$failAuthAttemptMessage"}
	 */
	public function loginAttempt($email, $password, $rememberMe = false, $intendedUrl, array $input);

	/**
	 * User logout attempt
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logoutAttempt();

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @param array $credentials
	 *	An array as follows: array('email'=>$email);
	 *
	 * @return Response
	 */
	public function remindUserPassword($credentials);

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @param array $credentials
	 *	An array as follows: array('email'=>email, 'password'=>$password, 'password_confirmation'=>$password_confirmation, 'token'=>$token);
	 *
	 * @return Response
	 */
	public function resetUserPassword($credentials);

	/**
	 * Handle a POST request to activate a user.
	 *
	 * @param array $credentials
	 *	An array as follows: array('email'=>email, 'password'=>$password, 'password_confirmation'=>$password_confirmation, 'token'=>$token);
	 *
	 * @return Response
	 */
	public function activateUser($credentials);

	/**
	 * Finds out if the current user is not logged in (a guest).
	 *
	 * @return true if is not logged (a guest), false otherwise.
	 */
	public function isUserGuest();

	/**
	 * Find out if an user is root
	 *
	 * @param  int $id User id
	 *
	 * @return boolean
	 *	True if is user is root, false otherwise
	 *
	 */
	public function isUserRoot($id = null);

	/**
  * Find out if an user is admin
  *
  * @param  int $id User id
  * @param  App\Kwaai\Security\User $User
  *
  * @return boolean
  *	True if is user is admin, false otherwise
  *
  */
  public function isUserAdmin($id = null, $User = null);

	/**
	 * Set current user organization
	 *
	 * @return void
	 */
	public function setCurrentUserOrganization(Organization $Organization);

	/**
	 * Unset current user organization
	 *
	 * @return void
	 */
	public function unsetCurrentUserOrganization();

	/**
	 * Get current user organization
	 *
	 * @return void
	 */
	public function getCurrentUserOrganization($columnName);

	/**
	* Get current user organization id
	*
	* @return string
	*/
	public function getCurrentUserOrganizationId();

	/**
	* Get current user organization connection
	*
	* @param  int $id organization id
	*
	* @return string
	*/
	public function getCurrentUserOrganizationConnection($id = null);

	/**
	* Get current user organization country
	*
	* @return string
	*/
	public function getCurrentUserOrganizationCountry();

	/**
	* Get current user organization courrency
	*
	* @return string
	*/
	public function getCurrentUserOrganizationCurrency();

	/**
	* Get current user organization name
	*
	* @return string
	*/
	public function getCurrentUserOrganizationName();

	/**
	 * Get logged user ID
	 *
	 * @return int
	 */
	public function getLoggedUserId();

	/**
	 * Get logged user firstname
	 *
	 * @return int
	 */
	public function getLoggedUserFirstname();

	/**
	 * Get logged user lastname
	 *
	 * @return int
	 */
	public function getLoggedUserLastname();

	/**
	 * Get logged user email
	 *
	 * @return int
	 */
	public function getLoggedUserEmail();

	/**
	 * Get logged user timezone
	 *
	 * @return string
	 */
	public function getLoggedUserTimeZone();

	/**
	 * Get logged user popover shown flag
	 *
	 * @return string
	 */
	public function getLoggedUserDefaultOrganization();

	/**
	 * Get logged user multiple organization popover shown flag
	 *
	 * @return string
	 */
	public function getLoggedUserPopoversShown();
}

<?php
/**
 * @file
 * Logout controller.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Http\Controllers\Security;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Http\Controllers\Controller;

class Logout extends Controller {

	/**
	 * Authenticator
	 *
	 * @var \App\Kwaai\Security\Services\Authentication\AuthenticationInterface
	 *
	 */
	protected $Auth;

	public function __construct(AuthenticationManagementInterface $Auth)
	{
		$this->Auth = $Auth;

		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getLogoutAttempt()
	{
		return $this->Auth->logoutAttempt();
	}

	public function getCasLogoutAttempt()
	{
		return $this->Auth->casLogoutAttempt();
	}

}

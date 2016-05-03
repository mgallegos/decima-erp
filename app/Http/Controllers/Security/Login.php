<?php
/**
 * @file
 * Login controller.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Http\Controllers\Security;


use Illuminate\Session\SessionManager;

use Illuminate\Routing\UrlGenerator;

use Illuminate\Http\Request;

use Illuminate\View\Factory;

use Illuminate\Config\Repository;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Http\Controllers\Controller;

use Cas;

class Login extends Controller {

	/**
	 * Authenticator
	 *
	 * @var \App\Kwaai\Security\Services\Authentication\AuthenticationInterface
	 *
	 */
	protected $Auth;

	/**
	 * View
	 *
	 * @var Illuminate\View\Factory
	 *
	 */
	protected $View;

	/**
	 * View
	 *
	 * @var Illuminate\Http\Request
	 *
	 */
	protected $Input;

	/**
	 * The URL generator instance
	 *
	 * @var \Illuminate\Routing\UrlGenerator
	 *
	 */
	protected $Url;

	/**
	 * Session
	 *
	 * @var Illuminate\Session\SessionManager
	 *
	 */
	protected $Session;

	/**
	 * Session
	 *
	 * @var Illuminate\Session\SessionManager
	 *
	 */
	protected $Config;


	public function __construct(AuthenticationManagementInterface $Auth, Factory $View, Request $Input, UrlGenerator $Url, SessionManager $Session, Repository $Config)
	{
		$this->Auth = $Auth;

		$this->View = $View;

		$this->Input = $Input;

		$this->Url = $Url;

		$this->Session = $Session;

		$this->Config = $Config;

		//$this->beforeFilter('check.auth', array('on' => 'get'));

		//$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex()
	{
		if($this->Config->get('system-security.cas'))
		{
			Cas::authenticate();
		}

		return $this->View->make('security.login');
	}

	public function getCasAuthenticationAttempt()
	{
		return $this->Auth->casLoginAttempt();
	}

	public function postAuthenticationAttempt()
	{
		return $this->Auth->loginAttempt($this->Input->json()->get('email'), $this->Input->json()->get('password'), $this->Input->json()->get('rememberMe'), $this->Session->get('url.intended', $this->Url->to('/')), $this->Input->json()->all());
	}
}

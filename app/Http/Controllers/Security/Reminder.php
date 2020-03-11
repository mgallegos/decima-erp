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

use Illuminate\Foundation\Application;

use Illuminate\Http\Request;

use Illuminate\View\Factory;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Http\Controllers\Controller;

class Reminder extends Controller {

	/**
	 * App
	 *
	 * @var lluminate\Foundation\Application
	 *
	 */
	protected $App;

	/**
	 * View
	 *
	 * @var Illuminate\View\Factory
	 *
	 */
	protected $View;

	/**
	 * Input
	 *
	 * @var Illuminate\Http\Request
	 *
	 */
	protected $Input;

	/**
	 * Session
	 *
	 * @var Illuminate\Session\SessionManager
	 *
	 */
	protected $Session;

	public function __construct(AuthenticationManagementInterface $AuthenticationManager, Application $App, Factory $View, Request $Input, SessionManager $Session)
	{
		$this->AuthenticationManager = $AuthenticationManager;

		$this->App = $App;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;
	}

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return $this->View->make('security/login/password-remind')
			->with('lastLoggedUserEmail', $this->AuthenticationManager->getLastLoggedUserEmail())
			->withStatus($this->Session->get('status', false))
			->withError($this->Session->get('error', false));
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 *
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) $this->App->abort(404);

		return $this->View->make('security/password-reset')
			->with('token', $token)
			->withError($this->Session->get('error', false));
	}

	/**
	 * Display the user activation view.
	 *
	 * @return Response
	 */
	public function getActivation($token = null)
	{
		if (is_null($token)) $this->App->abort(404);

		return $this->View->make('security/user-activation')
			->with('token', $token)
			->withError($this->Session->get('error', false));
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
		return $this->AuthenticationManager->remindUserPassword($this->Input->json()->all());
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		return $this->AuthenticationManager->resetUserPassword( $this->Input->all() );
	}

	/**
	 * Handle a POST request to activate a user.
	 *
	 * @return Response
	 */
	public function postActivate()
	{
		return $this->AuthenticationManager->activateUser( $this->Input->all() );
	}

}

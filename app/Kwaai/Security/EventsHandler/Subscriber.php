<?php
/**
 * @file
 * Handle user events.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\EventsHandler;

use Illuminate\Queue\QueueManager;

use Illuminate\Http\Request;

use Illuminate\Log\Writer;

class Subscriber {

	/**
	 * Laravel Writer (Log)
	 *
	 * @var Illuminate\Log\Writer
	 *
	 */
	protected $Log;

	/**
	 * Laravel Request
	 *
	 * @var Illuminate\Http\Request
	 *
	 */
	protected $Input;

	/**
	 * Laravel Queue
	 *
	 * @var Illuminate\Queue\QueueManager
	 *
	 */
	protected $Queue;

	public function __construct(Writer $Log, Request $Input, QueueManager $Queue)
	{
		$this->Log = $Log;

		$this->Input = $Input;

		$this->Queue = $Queue;
	}
	/**
	 * Handle user login events.
	 */
	public function onUserLogin()
	{
		//$this->Log->notice('[SECURITY EVENT] User logged in', array('email' => $this->Input->json()->get('email')));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] User logged in', 'context' => array('email' => $this->Input->json()->get('email'))));
	}

	/**
	 * Handle failed user login attempt events.
	 */
	public function onFailedLoginAttempt()
	{
		//$this->Log->notice('[SECURITY EVENT] Failed Login Attempt', array('email' => $this->Input->json()->get('email')));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] Failed Login Attempt', 'context' => array('email' => $this->Input->json()->get('email'))));
	}

	/**
	 * Handle user logout events.
	 */
	public function onUserLogout()
	{
		//$this->Log->notice('[SECURITY EVENT] User logged out', array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all()));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] User logged out', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}

	/**
	 * Handle user password reminder events.
	 */
	public function onPasswordReminder()
	{
		//$this->Log->notice('[SECURITY EVENT] User requested a password reminder email', array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all()));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] User requested a password reminder email', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}

	/**
	 * Handle user password reminder events.
	 */
	public function onFailedPasswordReminder()
	{
		//$this->Log->notice('[SECURITY EVENT] User failed to request a password reminder email', array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all()));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] User failed to request a password reminder email', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}

	/**
	 * Handle user password reminder events.
	 */
	public function onPasswordReset()
	{
		//$this->Log->notice('[SECURITY EVENT] User successfully reset his password', array('email' => $this->Input->get('email')));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] User successfully reset his password', 'context' => array('email' => $this->Input->get('email'))));
	}

	/**
	 * Handle user password reminder events.
	 */
	public function onFailedPasswordReset()
	{
		//$this->Log->notice('[SECURITY EVENT] User failed to reset his password', array('email' => $this->Input->get('email')));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] User failed to reset his password', 'context' => array('email' => $this->Input->get('email'))));
	}

	/**
	 * Handle user active account events.
	 */
	public function onActivateAccount()
	{
		//$this->Log->notice('[SECURITY EVENT] User successfully activated his account', array('email' => $this->Input->get('email')));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] User successfully activated his account', 'context' => array('email' => $this->Input->get('email'))));
	}

	/**
	 * Handle user active account events.
	 */
	public function onFailedActivateAccount()
	{
		//$this->Log->notice('[SECURITY EVENT] User failed to activate his account', array('email' => $this->Input->get('email')));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] User failed to activate his account', 'context' => array('email' => $this->Input->get('email'))));
	}

	/**
	 * Handle user add operation events.
	 */
	public function onUserStandardAdded()
	{
		//$this->Log->notice('[SECURITY EVENT] A new user has been added to the organization', array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all()));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] A new user has been added to the organization', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}

	/**
	 * Handle user add operation events.
	 */
	public function onUserAdminAdded()
	{
		//$this->Log->notice('[SECURITY EVENT] A new admin user has been added to the system', array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all()));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] A new admin user has been added to the system', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}

	/**
	 * Handle user add operation warnings.
	 */
	public function onUserAdd()
	{
		//$this->Log->warning('[SECURITY EVENT] A non-admin user tried to add an admin user', array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all()));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@warning', array('message' => '[SECURITY EVENT] A non-admin user tried to add an admin user', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}

	/**
	 * Handle user update operation warnings.
	 */
	public function onUserUpdate()
	{
		//$this->Log->warning('[SECURITY EVENT] User tried to update a user that has not been created by him', array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all()));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@warning', array('message' => '[SECURITY EVENT] User tried to update a user that has not been created by him', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}

	/**
	 * Handle user delete operation warnings.
	 */
	public function onUserDelete()
	{
		//$this->Log->warning('[SECURITY EVENT] User tried to delete a root user', array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all()));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@warning', array('message' => '[SECURITY EVENT] User tried to delete a root user', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}

	/**
	* Handle page not found warnings.
	*/
	public function onPageNotFound()
	{
		$this->Queue->push('App\Kwaai\Helpers\LogHandler@warning', array('message' => '[SECURITY EVENT] User tried to access a non-existent page', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}

	/**
	* Handle invalid browser warnings.
	*/
	public function onInvalidBrowser()
	{
		$this->Queue->push('App\Kwaai\Helpers\LogHandler@warning', array('message' => '[SECURITY EVENT] User tried to access the aplication usign an unsupported browser', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}

	/**
	 * Handle user organization changes operation.
	 */
	public function onUserOrganizationChange()
	{
		//$this->Log->notice('[SECURITY EVENT] User has changed his current organization', array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all()));

		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[SECURITY EVENT] User has changed his current organization', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}

	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param  Illuminate\Events\Dispatcher  $events
	 *
	 * @return array
	 */
	public function subscribe($events)
	{
		// $events->listen('user.login', 'App\Kwaai\Security\EventsHandler\Subscriber@onUserLogin');

		// $events->listen('user.failed.login', 'App\Kwaai\Security\EventsHandler\Subscriber@onFailedLoginAttempt');

		// $events->listen('user.logout', 'App\Kwaai\Security\EventsHandler\Subscriber@onUserLogout');

		// $events->listen('user.password.reminder', 'App\Kwaai\Security\EventsHandler\Subscriber@onPasswordReminder');

		// $events->listen('user.failed.password.reminder', 'App\Kwaai\Security\EventsHandler\Subscriber@onFailedPasswordReminder');

		// $events->listen('user.password.reset', 'App\Kwaai\Security\EventsHandler\Subscriber@onPasswordReset');

		// $events->listen('user.failed.password.reset', 'App\Kwaai\Security\EventsHandler\Subscriber@onFailedPasswordReset');

		// $events->listen('user.activate.account', 'App\Kwaai\Security\EventsHandler\Subscriber@onActivateAccount');

		// $events->listen('user.failed.activate.account', 'App\Kwaai\Security\EventsHandler\Subscriber@onFailedActivateAccount');

		//--

		// $events->listen('user.add.standard', 'App\Kwaai\Security\EventsHandler\Subscriber@onUserStandardAdded');

		// $events->listen('user.add.admin', 'App\Kwaai\Security\EventsHandler\Subscriber@onUserAdminAdded');

		// $events->listen('user.add.warning', 'App\Kwaai\Security\EventsHandler\Subscriber@onUserAdd');

		// $events->listen('user.update.warning', 'App\Kwaai\Security\EventsHandler\Subscriber@onUserUpdate');

		// $events->listen('user.delete.warning', 'App\Kwaai\Security\EventsHandler\Subscriber@onUserDelete');

		//--

		// $events->listen('page.not.found.warning', 'App\Kwaai\Security\EventsHandler\Subscriber@onPageNotFound');

		// $events->listen('invalid.browser.warning', 'App\Kwaai\Security\EventsHandler\Subscriber@onInvalidBrowser');

		// $events->listen('user.organization.change', 'App\Kwaai\Security\EventsHandler\Subscriber@onUserOrganizationChange');
	}
}

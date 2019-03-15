<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Services\AuthenticationManagement;

use Carbon\Carbon;

use Illuminate\Validation\Factory;

use Illuminate\Contracts\Hashing\Hasher;

use Illuminate\Auth\Passwords\PasswordBroker;

use Illuminate\Auth\Passwords\PasswordBrokerManager;

use Illuminate\Config\Repository;

use Illuminate\Http\Request;

use Illuminate\Cookie\CookieJar;

use Illuminate\Session\SessionManager;

use Illuminate\Routing\Redirector;

use Illuminate\Events\Dispatcher;

use Illuminate\Routing\UrlGenerator;

use Illuminate\Auth\AuthManager;

use Illuminate\Translation\Translator;

use Illuminate\Cache\CacheManager;

use App\Kwaai\Organization\Organization;

use App\Kwaai\Security\Repositories\User\UserInterface;

use App\Kwaai\System\Repositories\Currency\CurrencyInterface;

use App\Kwaai\System\Repositories\Country\CountryInterface;

use App\Kwaai\System\Services\Validation\AbstractLaravelValidator;

use App\Kwaai\Organization\Repositories\Organization\OrganizationInterface;

use App\Kwaai\Security\Services\Authentication\AuthenticationInterface;

use App\Events\OnNewInfoMessage;

use App\Events\OnNewWarningMessage;

use Xavrsl\Cas\CasManager;

class LaravelAuthenticationManager extends AbstractLaravelValidator implements AuthenticationManagementInterface {

	/**
	 * Organization
	 *
	 * @var App\Kwaai\Security\Repositories\Organization\OrganizationInterface
	 *
	 */
	protected $Organization;

	/**
	 * User
	 *
	 * @var App\Kwaai\Security\Repositories\User\UserInterface
	 *
	 */
	protected $User;

	/**
	* Currency Interface
	*
	* @var App\Kwaai\System\Repositories\Currency\CurrencyInterface
	*
	*/
	protected $Currency;

	/**
	* Country Interface
	*
	* @var App\Kwaai\System\Repositories\Country\CountryInterface
	*
	*/
	protected $Country;

	/**
	 * Laravel Authenticator instance
	 *
	 * @var \Illuminate\Auth\AuthManager
	 *
	 */
	protected $Auth;

	/**
	 * Laravel Translator instance
	 *
	 * @var \Illuminate\Translation\Translator
	 *
	 */
	protected $Lang;

	/**
	 * Laravel Cache instance
	 *
	 * @var \Illuminate\Cache\CacheManager
	 *
	 */
	protected $Cache;

	/**
	 * The URL generator instance
	 *
	 * @var \Illuminate\Routing\UrlGenerator
	 *
	 */
	protected $Url;

	/**
	 * Laravel Dispatcher instance
	 *
	 * @var \Illuminate\Events\Dispatcher
	 *
	 */
	protected $Event;

	/**
	 * Laravel Redirector instance
	 *
	 * @var \Illuminate\Routing\Redirector
	 *
	 */
	protected $Redirector;

	/**
	 * Laravel CookieJar
	 *
	 * @var \Illuminate\Cookie\CookieJar
	 *
	 */
	protected $Cookie;

	/**
	 * Laravel Request
	 *
	 * @var \Illuminate\Http\Request
	 *
	 */
	protected $Input;

	/**
	 * Laravel Repository instance
	 *
	 * @var Illuminate\Config\Repository
	 *
	 */
	protected $Config;

	/**
	 * Laravel Password instance
	 *
	 * @var Illuminate\Auth\Passwords\PasswordBroker
	 *
	 */
	protected $Password;

	/**
	 * Laravel Hasher instance
	 *
	 * @var Illuminate\Contracts\Hashing\Hasher
	 *
	 */
	protected $Hash;

	/**
	 * Session
	 *
	 * @var Illuminate\Session\SessionManager
	 *
	 */
	protected $Session;

	/**
	* Laravel Validator
	*
	* @var Illuminate\Validation\Factory
	*
	*/
	protected $Validator;

	/**
	* Validation rules
	*
	* @var Array
	*/
	protected $rules;

	/**
	 * Cas
	 *
	 * @var Xavrsl\Cas\CasManager
	 *
	 */
	protected $Cas;

	public function __construct(
		OrganizationInterface $Organization,
		UserInterface $User,
		CurrencyInterface $Currency,
		CountryInterface $Country,
		AuthManager $Auth,
		Translator $Lang,
		CacheManager $Cache,
		UrlGenerator $Url,
		Dispatcher $Event,
		Redirector $Redirector,
		CookieJar $Cookie,
		Request $Input,
		Repository $Config,
		PasswordBrokerManager $Password,
		Hasher $Hash,
		SessionManager $Session,
		Factory $Validator,
		CasManager $Cas
	)
	{
		$this->Organization = $Organization;

		$this->User = $User;

		$this->Currency = $Currency;

		$this->Country = $Country;

		$this->Auth = $Auth;

		$this->Lang = $Lang;

		$this->Cache = $Cache;

		$this->Url = $Url;

		$this->Event = $Event;

		$this->Redirector = $Redirector;

		$this->Cookie = $Cookie;

		$this->Input = $Input;

		$this->Config = $Config;

		$this->Password = $Password;

		$this->Hash = $Hash;

		$this->Session = $Session;

		$this->Validator = $Validator;

		$this->Cas = $Cas;

		$this->defaultDatabaseConnectionName = 'default';

		$this->rules = array(
			'kwaai_name' => 'honeypot',
			'kwaai_time' => 'required|honeytime:2'
		);
	}

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
	public function loginAttempt($email, $password, $rememberMe = false, $intendedUrl, array $input)
	{
		if(!isset($input['kwaai_name']))
    {
      die('Sorry robot!');
    }

		$data = array(
			'kwaai_name' => $input['kwaai_name'],
			'kwaai_time' => $input['kwaai_time'],
		);

		if( $this->with( $data )->fails() )
		{
			die('kwaai_time validation failed!');
		}

		if($rememberMe == '0')
		{
			$rememberMe = false;
		}
		else
		{
			$rememberMe = true;
		}

		if ($this->Auth->attempt(array('email' => $email, 'password' => $password, 'is_active' => true), $rememberMe))
		{
			if(strpos($intendedUrl, "logout") !== false)
			{
				$intendedUrl = $this->Url->to('/dashboard');
			}

			$this->Session->put('loggedUser', json_encode($this->Auth->user()->toArray()));

			$userDefaultOrganizationId = $this->getLoggedUserDefaultOrganization();

			if(!empty($userDefaultOrganizationId))
			{
				$this->setCurrentUserOrganization($this->Organization->byId($userDefaultOrganizationId));
			}

			// $this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] System User logged in', 'context' => array('email' => $email)), $this));

			return json_encode(array('message' => 'success', 'url' => $intendedUrl));
		}
		else
		{
			// $this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] System Failed Login Attempt', 'context' => array('email' => $email)), $this));

			return json_encode(array('message' => $this->Lang->get('security/login.failAuthAttempt')));
		}
	}

	/**
	 * User cas login authentication attempt
	 *
	 * @return void
	 */
	public function casLoginAttempt()
	{
		$User = $this->User->byEmail($this->Cas->getCurrentUser() . '@' . $this->Config->get('system-security.cas_domain'));

		if($User->isEmpty())
		{
			return $this->Redirector->to('error')->withError($this->Lang->get('security/login.notExistingUser'));
		}

		$User = $User->first();

		if(empty($User->is_active))
		{
			return $this->Redirector->to('error')->withError($this->Lang->get('security/login.notActiveUser'));
		}

		$this->Auth->login($User);

		$userDefaultOrganizationId = $this->getLoggedUserDefaultOrganization();

		if(!empty($userDefaultOrganizationId))
		{
			$this->setCurrentUserOrganization($this->Organization->byId($userDefaultOrganizationId));
		}

		return $this->Redirector->to('/dashboard');
	}

	/**
	 * User logout attempt
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logoutAttempt()
	{
		$this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] User logged out', 'context' => array('email' => $this->getLoggedUserEmail())), $this));

		$this->Auth->logout();

		$this->unsetCurrentUserOrganization();

		$this->Session->forget('loggedUser');

		if($this->Config->get('system-security.cas'))
		{
			return $this->Redirector->to('caslogout');
		}
		else
		{
			return $this->Redirector->guest('login');
		}
	}

	/**
	 * User logout attempt
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function casLogoutAttempt()
	{
		return $this->Cas->logout();
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @param array $credentials
	 *	An array as follows: array('email'=>$email);
	 *
	 * @return Response
	 */
	public function remindUserPassword($credentials)
	{
		$data = array(
			'kwaai_name' => $credentials['kwaai_name'],
			'kwaai_time' => $credentials['kwaai_time'],
		);

		if( $this->with( $data )->fails() )
		{
			die('fail');
		}

		unset($credentials['_token'], $credentials['kwaai_name'], $credentials['kwaai_time']);

		$this->Session->flash('email', $credentials['email']);

		$emailSubject = $this->Lang->get('security/reminders.emailSubject', array('systemName' => $this->Config->get('system-security.system_name'), 'datetime' => Carbon::now()->format($this->Lang->get('form.phpDateFormat'))));
		$replyToEmail = $this->Config->get('system-security.reply_to_email');
		$replyToName = $this->Config->get('system-security.reply_to_name');

		$response = $this->Password->sendResetLink($credentials, function($message) use ($emailSubject, $replyToEmail, $replyToName)
		{
			$message->subject($emailSubject)->replyTo($replyToEmail, $replyToName);
		});

		switch ($response)
		{
			case PasswordBroker::INVALID_USER:
				$this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User failed to request a password reminder email', 'context' => array('email' => $credentials['email'])), $this));
				return $this->Redirector->back()->with('error', $this->Lang->get('security/' . $response));

			case PasswordBroker::RESET_LINK_SENT:
				$this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] User requested a password reminder email', 'context' => array('email' => $credentials['email'])), $this));
				return $this->Redirector->back()->with('status', $this->Lang->get('security/' . $response));
		}
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @param array $credentials
	 *	An array as follows: array('email'=>email, 'password'=>$password, 'password_confirmation'=>$password_confirmation, 'token'=>$token);
	 *
	 * @return Response
	 */
	public function resetUserPassword($credentials)
	{
		$data = array(
			'kwaai_name' => $credentials['kwaai_name'],
			'kwaai_time' => $credentials['kwaai_time'],
		);

		if( $this->with( $data )->fails() )
		{
			die('fail');
		}

		unset($credentials['_token'], $credentials['kwaai_name'], $credentials['kwaai_time']);

		$response = $this->Password->reset($credentials, function($user, $password)
		{
			//$user->password = $this->Hash->make($password);
			$user->password = bcrypt($password);

			$user->save();
		});

		switch ($response)
		{
			case PasswordBroker::PASSWORD_RESET:
				$this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] User successfully reset his password', 'context' => array('email' => $credentials['email'])), $this));
				return $this->Redirector->to('login');
			default:
				$this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User failed to reset his password', 'context' => array('email' => $credentials['email'])), $this));
				return $this->Redirector->back()->with('error', $this->Lang->get('security/' . $response));
		}
	}

	/**
	 * Handle a POST request to activate a user.
	 *
	 * @param array $credentials
	 *	An array as follows: array('email'=>email, 'password'=>$password, 'password_confirmation'=>$password_confirmation, 'token'=>$token);
	 *
	 * @return Response
	 */
	public function activateUser($credentials)
	{
		$data = array(
			'kwaai_name' => $credentials['kwaai_name'],
			'kwaai_time' => $credentials['kwaai_time'],
		);

		if( $this->with( $data )->fails() )
		{
			die('fail');
		}

		unset($credentials['_token'], $credentials['kwaai_name'], $credentials['kwaai_time']);

		$User = $this->User->byEmail($credentials['email']);

		if($User->isEmpty())
		{
			$this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User failed to activate his account', 'context' => array('email' => $credentials['email'], 'errorType' => 'Invalid User')), $this));
			return $this->Redirector->back()->with('error', $this->Lang->get('security/' . PasswordBroker::INVALID_USER));
		}

		if($User[0]->activation_code != $credentials['token'])
		{
			$this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User failed to activate his account', 'context' => array('email' => $credentials['email'], 'errorType' => 'Invalid Token')), $this));
			return $this->Redirector->back()->with('error', $this->Lang->get('security/' . PasswordBroker::INVALID_TOKEN));
		}

		if($credentials['password'] != $credentials['password_confirmation'] || !$credentials['password'] || strlen($credentials['password']) < 6)
		{
			$this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User failed to activate his account', 'context' => array('email' => $credentials['email'], 'errorType' => 'Invalid Password')), $this));
			return $this->Redirector->back()->with('error', $this->Lang->get('security/' . PasswordBroker::INVALID_PASSWORD));
		}

		$this->User->update(array('id' => $User[0]->id, 'password' => $this->Hash->make($credentials['password']), 'is_active' => 1, 'activated_at' => Carbon::now(), 'activation_code' => null));
		$this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] User successfully activated his account', 'context' => array('email' => $credentials['email'])), $this));

		return $this->Redirector->to('login');
	}

	/**
	 * Finds out if the current user is not logged in (a guest).
	 *
	 * @return true if is not logged (a guest), false otherwise.
	 */
	public function isUserGuest()
	{
		// return $this->Auth->guest();

		if($this->Session->has('loggedUser'))
		{
			return false;
		}

		return true;
		// // var_dump('isUserGuest');
		// return $this->Auth->guest();
	}


	/**
	 * Find out if an user is root
	 *
	 * @param  int $id User id
	 *
	 * @return boolean
	 *	True if is user is root, false otherwise
	 *
	 */
	public function isUserRoot($id = null)
	{
		// var_dump('isUserRoot');
		if(empty($id))
		{
			$id = $this->getLoggedUserId();
		}

		if(in_array($id, $this->getRootUsersId()))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Find out if an user has not change the default values for root.
	 *
	 * @param  int $id User id
	 *
	 * @return boolean
	 *	True if is user is root, false otherwise
	 *
	 */
	public function isUserDefaultRoot($id = null)
	{
		// var_dump('isUserDefaultRoot');

		// return true;

		if(!$this->isUserRoot($id))
		{
			return false;
		}

		if(empty($id))
		{
			$user = $this->getSessionLoggedUser();
			// $User = $this->Auth->user();
		}
		else
		{
			$user = $this->User->byId($id)->toArray();
		}

		if($user['email'] == $this->Config->get('system-security.root_default_email'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

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
	public function isUserAdmin($id = null, $User = null)
	{
		// var_dump('isUserAdmin');
		// if(empty($id))
		// {
		// 	$User = $this->Auth->user();
		// }
		// else
		// {
		// 	if(empty($User))
    //   {
    //     $User = $this->User->byId($id);
    //   }
		// }

		if(empty($id))
		{
			$user = $this->getSessionLoggedUser();
			// $User = $this->Auth->user();
		}
		else
		{
			if(empty($User))
      {
				$user = $this->User->byId($id)->toArray();
      }
			else
			{
				$user = $User->toArray();
			}
		}

		if(!empty($user['is_admin']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Verify is the connection is the default connection
	 *
	 * @param string $databaseConnectionName
	 *
	 * @return true if it is the default database connection name, false otherwise
	 */
	public function isDefaultDatabaseConnectionName($databaseConnectionName = null)
	{
		// var_dump('isDefaultDatabaseConnectionName');
		if(empty($databaseConnectionName))
		{
			$databaseConnectionName = $this->getCurrentUserOrganizationConnection();
		}

		if($databaseConnectionName == $this->defaultDatabaseConnectionName)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Set current user organization
	 *
	 * @return void
	 */
	public function setCurrentUserOrganization(Organization $Organization)
	{
		// $this->Cookie->queue($this->Cookie->forever($this->getCurrentOrganizationCookieName(), $Organization->id));
		$this->Session->forget('currentOrganization');
		$this->Session->put('currentOrganization', json_encode($Organization->toArray()));
		$this->unsetCurrentOrganizationCountry();
	}

	/**
	 * Unset current user organization
	 *
	 * @return void
	 */
	public function unsetCurrentUserOrganization()
	{
		// $this->Cookie->queue($this->Cookie->forget($this->getCurrentOrganizationCookieName()));
		$this->Session->forget('currentOrganization');
		$this->unsetCurrentOrganizationCountry();
	}

	/**
	 * Set current user organization
	 *
	 * @return void
	 */
	public function setCurrentOrganizationCountry($Country)
	{
		$this->Session->put('currentCountry', json_encode($Country->toArray()));
	}

	/**
	 * Unset current user organization
	 *
	 * @return void
	 */
	public function unsetCurrentOrganizationCountry()
	{
		$this->Session->forget('currentCountry');
	}

	/**
	 * Get session organization
	 *
	 * @return int
	 */
	public function getSessionOrganization()
	{
		return json_decode($this->Session->get('currentOrganization'), true);
	}

	/**
	 * Get session organization
	 *
	 * @return int
	 */
	public function getSessionCountry()
	{
		if($this->Session->has('currentCountry'))
		{
			$country = json_decode($this->Session->get('currentCountry'), true);
		}
		else
		{
			$Country = $this->Country->byId($this->getCurrentUserOrganizationCountry());
			$country = $Country->toArray();
			$this->setCurrentOrganizationCountry($Country);
		}

		return $country;
	}

	/**
	 * Get logged user ID
	 *
	 * @return int
	 */
	public function getSessionLoggedUser()
	{
		if($this->Session->has('loggedUser'))
		{
			$user = json_decode($this->Session->get('loggedUser'), true);
		}
		else
		{
			$User =  $this->Auth->user();
			$user = $User->toArray();
			$this->Session->put('loggedUser', json_encode($user));
		}

		return $user;
	}

	/**
	 * Get default database connection name
	 *
	 * @param string $columnName
	 *
	 * @return column or object
	 */
	public function getDefaultDatabaseConnectionName()
	{
		return $this->defaultDatabaseConnectionName;
	}

	/**
	* Get current user organization id
	*
	* @return string
	*/
	public function getCurrentUserOrganizationId()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return 0;
		}
		else
		{
			return $organization['id'];
		}

		// // var_dump('getCurrentUserOrganizationId');
		// $value = $this->Input->cookie($this->getCurrentOrganizationCookieName(), '');
    //
		// if(!is_int($value))
		// {
		// 	$userDefaultOrganizationId = $this->getLoggedUserDefaultOrganization();
    //
		// 	if(!empty($userDefaultOrganizationId))
		// 	{
		// 		$this->setCurrentUserOrganization($this->Organization->byId($userDefaultOrganizationId));
    //
		// 		return $userDefaultOrganizationId;
		// 	}
    //
		// 	return -1;
		// }
    //
		// return $value;
	}

	/**
	 * Get current user organization
	 *
	 * @param string $columnName
	 *
	 * @return column or object
	 */
	public function getCurrentUserOrganization($columnName = null)
	{
		$Organization = json_decode($this->Session->get('currentOrganization'));

		if(empty($Organization))
		{
			return -1;
		}

		if(empty($columnName))
		{
			return $Organization;
		}

		return $Organization->$columnName;

		// var_dump('getCurrentUserOrganization');
		// $value = $this->getCurrentUserOrganizationId();
    //
		// if(!empty($value))
		// {
		// 	$value = $this->Organization->byId($value);
		// }
    //
		// if(is_object($value))
		// {
		// 	if(empty($columnName))
		// 	{
		// 		return $value;
		// 	}
    //
		// 	$value = $value->$columnName;
		// }
		// else
		// {
		// 	if($columnName == 'id')
		// 	{
		// 		return -1;
		// 	}
		// }
    //
		// return $value;
	}

	/**
	* Get current user organization connection
	*
	* @param  int $value organization id
	*
	* @return string
	*/
	public function getCurrentUserOrganizationConnection($organizationId = null)
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization) && empty($organizationId))
		{
			return $this->defaultDatabaseConnectionName;
		}

		if(!empty($organizationId) && $organization['id'] != $organizationId)
		{
			return $this->getOrganizationConnection($organizationId);
		}

		return $organization['database_connection_name'];

		// var_dump('getCurrentUserOrganizationConnection');
		// if(empty($value))
		// {
		// 	$value = $this->Input->cookie($this->getCurrentOrganizationCookieName(), '');
		// }
    //
		// if(!is_int($value))
		// {
		// 	return $this->defaultDatabaseConnectionName;
		// }
    //
		// $value = $this->Organization->byId($value);
    //
		// if(is_object($value))
		// {
		// 	$value = $value->database_connection_name;
		// }
    //
		// return $value;
	}

	/**
	* Get organization connection
	*
	* @param  int $value organization id
	*
	* @return string
	*/
	public function getOrganizationConnection($organizationId)
	{
		if($this->Cache->has('organization' . $organizationId))
		{
			$organization = json_decode($this->Cache->get('organization' . $organizationId), true);
		}
		else
		{
			$organization = $this->Organization->byId($organizationId)->toArray();
			$this->Cache->put('organization' . $organizationId, json_encode($organization), 360);
		}

		return $organization['database_connection_name'];
	}

	/**
	* Get organization connection
	*
	* @param  int $value organization id
	*
	* @return string
	*/
	public function getOrganizationByApiToken($token)
	{
		$Organizations = $this->Organization->byApiToken($token);

		if($Organizations->isEmpty())
		{
			return '';
		}

		return $Organizations->first();
	}

	/**
	* Get current user organization country
	*
	* @return string
	*/
	public function getCurrentUserOrganizationCountry()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return -1;
		}
		else
		{
			return $organization['country_id'];
		}

		// $value = $this->getCurrentUserOrganizationId();
    //
		// $value = $this->Organization->byId($value);
    //
		// if(is_object($value))
		// {
		// 	$value = $value->country_id;
		// }
    //
		// return $value;
	}

	/**
	* Get current user organization country
	*
	* @return string
	*/
	public function getCurrentUserOrganizationCountryObject()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return -1;
		}
		else
		{
			return $organization['country_id'];
		}

		// $value = $this->getCurrentUserOrganizationId();
    //
		// $value = $this->Organization->byId($value);
    //
		// if(is_object($value))
		// {
		// 	$value = $value->country_id;
		// }
    //
		// return $value;
	}

	/**
	* Get current user organization courrency
	*
	* @return string
	*/
	public function getCurrentUserOrganizationCurrency()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return -1;
		}
		else
		{
			return $organization['currency_id'];
		}
		// $value = $this->getCurrentUserOrganizationId();
    //
		// $value = $this->Organization->byId($value);
    //
		// if(is_object($value))
		// {
		// 	$value = $value->currency_id;
		// }
    //
		// return $value;
	}

	/**
	* Get current user organization courrency
	*
	* @return string
	*/
	public function getCurrentUserOrganizationCurrencySymbol($organizationId = null)
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization) && !empty($organizationId))
		{
			$Organization = $this->Organization->byId($organizationId);

			if(!empty($Organization))
			{
				$organization = $Organization->toArray();
			}
		}

		if(empty($organization))
		{
			return -1;
		}
		else
		{
			if($this->Cache->has('currency' . $organization['currency_id']))
			{
				$currency = json_decode($this->Cache->get('currency' . $organization['currency_id']), true);
			}
			else
			{
				$currency = $this->Currency->byId($organization['currency_id'])->toArray();
				$this->Cache->put('currency' . $organization['currency_id'], json_encode($currency), 360);
			}

			return $currency['symbol'];
		}
		// $value = $this->getCurrentUserOrganizationId();
    //
		// $value = $this->Organization->byId($value);
    //
		// if(is_object($value))
		// {
		// 	$Currency = $this->Currency->byId($value->currency_id);
		// 	$value = $Currency->symbol;
		// }
    //
		// return $value;
	}

	/**
	* Get current user organization courrency
	*
	* @return string
	*/
	public function getCurrentUserOrganizationCurrencyIsoCode()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return -1;
		}
		else
		{
			if($this->Cache->has('currency' . $organization['currency_id']))
			{
				$currency = json_decode($this->Cache->get('currency' . $organization['currency_id']), true);
			}
			else
			{
				$currency = $this->Currency->byId($organization['currency_id'])->toArray();
				$this->Cache->put('currency' . $organization['currency_id'], json_encode($currency), 360);
			}

			return $currency['iso_code'];
		}
	}

	/**
	* Get current user organization name
	*
	* @return string
	*/
	public function getCurrentUserOrganizationName()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return '';
		}
		else
		{
			return $organization['name'];
		}
		// var_dump('getCurrentUserOrganizationName');
		// $value = $this->getCurrentUserOrganizationId();
    //
		// $value = $this->Organization->byId($value);
    //
		// if(is_object($value))
		// {
		// 	$value = $value->name;
		// }
    //
		// return $value;
	}

	/**
	* Get current user organization name
	*
	* @return string
	*/
	public function getCurrentUserOrganizationLogoUrl()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return '';
		}
		else
		{
			return $organization['logo_url'];
		}

		// $value = $this->getCurrentUserOrganizationId();
    //
		// $value = $this->Organization->byId($value);
    //
		// if(is_object($value))
		// {
		// 	$value = $value->logo_url;
		// }
    //
		// return $value;
	}

	/**
	* Get current user organization cost price precision
	*
	* @return string
	*/
	public function getCurrentUserOrganizationCostPricePrecision()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return 2;
		}
		else
		{
			return $organization['cost_price_precision'];
		}
	}

	/**
	* Get current user organization cost price precision
	*
	* @return string
	*/
	public function getCurrentUserOrganizationDiscountPrecision()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return 2;
		}
		else
		{
			return $organization['discount_precision'];
		}
	}

	/**
	* Get current user organization sale point quantity
	*
	* @return string
	*/
	public function getCurrentUserOrganizationSalePointQuantity($organizationId = null)
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization) && !empty($organizationId))
		{
			$Organization = $this->Organization->byId($organizationId);

			if(!empty($Organization))
			{
				$organization = $Organization->toArray();
			}
		}

		if(empty($organization))
		{
			return 0;
		}
		else
		{
			return $organization['sale_point_quantity'];
		}
	}

	/**
	 * Get logged user ID
	 *
	 * @return int
	 */
	public function getLoggedUserId()
	{
		if ($this->isUserGuest())
		{
			return -1;
		}

		$user = $this->getSessionLoggedUser();

		return $user['id'];
	}

	/**
	 * Get logged user firstname
	 *
	 * @return string
	 */
	public function getLoggedUserFirstname()
	{
		// // var_dump($value);

		if ($this->isUserGuest())
		{
			return '';
		}

		$user = $this->getSessionLoggedUser();

		// return $this->Auth->user()->firstname;
		return $user['firstname'];
	}

	/**
	 * Get logged user lastname
	 *
	 * @return string
	 */
	public function getLoggedUserLastname()
	{
		if ($this->isUserGuest())
		{
			return '';
		}

		$user = $this->getSessionLoggedUser();

		// return $this->Auth->user()->lastname;
		return $user['lastname'];
	}

	/**
	 * Get logged user email
	 *
	 * @return string
	 */
	public function getLoggedUserEmail()
	{
		if ($this->isUserGuest())
		{
			return '';
		}

		$user = $this->getSessionLoggedUser();

		// return $this->Auth->user()->email;
		return $user['email'];
	}

	/**
	 * Get logged user timezone
	 *
	 * @return string
	 */
	public function getLoggedUserTimeZone()
	{
		if ($this->isUserGuest())
		{
			return $this->Config->get('app.timezone');
		}

		$user = $this->getSessionLoggedUser();

		if (empty($user['timezone']))
		{
			return $this->Config->get('app.timezone');
		}

		// return $this->Auth->user()->timezone;
		return $user['timezone'];
	}

	/**
	 * Get logged user default Organization
	 *
	 * @return string
	 */
	public function getLoggedUserDefaultOrganization()
	{
		// var_dump('getLoggedUserDefaultOrganization');
		if ($this->isUserGuest())
		{
			return null;
		}

		$user = $this->getSessionLoggedUser();

		// return $this->Auth->user()->default_organization;

		return $user['default_organization'];
	}

	/**
	* Get logged user popover shown flag
	*
	* @return string
	*/
	public function getLoggedUserPopoversShown()
	{
		if ($this->isUserGuest())
		{
			return true;
		}

		$user = $this->getSessionLoggedUser();

		// return $this->Auth->user()->popovers_shown;
		return $user['popovers_shown'];
	}

	/**
	* Get logged user multiple organization popover shown flag
	*
	* @return string
	*/
	public function getLoggedUserMultipleOrganizacionPopoversShown()
	{
		if ($this->isUserGuest())
		{
			return true;
		}

		$user = $this->getSessionLoggedUser();

		// return $this->Auth->user()->multiple_organization_popover_shown
		return $user['multiple_organization_popover_shown'];
	}

	/**
	 * Is CMS user guest
	 *
	 * @return int
	 */
	public function isCmsUserGuest($prefix = '')
	{
		if($this->Session->has($prefix . 'CmsLoggedUser'))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Get CMS logged user
	 *
	 * @return int
	 */
	public function getCmsSessionLoggedUser($prefix = '', $column = '')
	{
		$user = array();

		if($this->Session->has($prefix . 'CmsLoggedUser'))
		{
			$user = json_decode($this->Session->get($prefix . 'CmsLoggedUser'), true);

			if(empty($column))
			{
				return $user;
			}
		}

		if(!empty($user) && isset($user[$column]))
		{
			return $user[$column];
		}

		return false;
	}

	/**
	 * Get the name of the cookie used to store the current organization id.
	 *
	 * @return string
	 */
	public function getCurrentOrganizationCookieName()
	{
		return 'current_organization_'.md5(get_class($this));
	}

	/**
	 * Get root user id.
	 *
	 * @return array
	 */
	public function getRootUsersId()
	{
		return $this->Config->get('system-security.root_users_id');
	}
}

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
use Illuminate\Log\Writer;
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
   * Laravel Writer (Log)
   *
   * @var Illuminate\Log\Writer
   *
   */
  protected $Log;

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
		Writer $Log,
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
		$this->Log = $Log;
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
			'kwaai_time' => 'required|honeytime:1'
		);
	}

	/**
	 * Api sign up with email and password
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
	public function apiSignUp(array $input)
	{
		// Sign up with email / password
		// You can create a new email and password user by issuing an HTTP POST request to the Auth signupNewUser endpoint.
		
		// https://firebase.google.com/docs/reference/rest/auth#section-create-email-password

		// example returned data

		// data:
		// 	kind: "identitytoolkit#SignupNewUserResponse"
		// 	idToken: "eyJhbGciOiJSUzI1NiIsImtpZCI6IjgzYTczOGUyMWI5MWNlMjRmNDM0ODBmZTZmZWU0MjU4Yzg0ZGI0YzUiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vdmlydHVhbC1jYWlybi0yNjUxMDIiLCJhdWQiOiJ2aXJ0dWFsLWNhaXJuLTI2NTEwMiIsImF1dGhfdGltZSI6MTU4NTkzNjQ0MywidXNlcl9pZCI6IlRlNE1aV2hwY2dUT2tJNnVta1FUa0liYkttdjIiLCJzdWIiOiJUZTRNWldocGNnVE9rSTZ1bWtRVGtJYmJLbXYyIiwiaWF0IjoxNTg1OTM2NDQzLCJleHAiOjE1ODU5NDAwNDMsImVtYWlsIjoidGVzdEBoZWxsby5jb20iLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsImZpcmViYXNlIjp7ImlkZW50aXRpZXMiOnsiZW1haWwiOlsidGVzdEBoZWxsby5jb20iXX0sInNpZ25faW5fcHJvdmlkZXIiOiJwYXNzd29yZCJ9fQ.Dwrs6BwiHDsBROSh3oMZvmlioKCk6DAbO5_eVe3t3NX4Jqpt3nJMwP7AVjDfer2ITjtFCK6hcSqlOpJx688mWEYnQjH188WD_8ljnWKBMFymWOkvzfIDSlo046R_NQpx7SJiRDqm8op6xsNCL9x5hrXw467lgNQOuEuyQfGpXzM_OmMBfskTJZdmbzhK8D_CyMzYsrH4Gw37663oDQGRHCttOQq83H8No1vyokGP26y1sEXcMFou95xs_6UWmjEZXm6sNODqS2KX1mjEbwmb3S9xYaB36msPF3pb74_lso1yWmWhS-9Pln6YVAE1RXfIEcbtKjW5o5u8L95p7J9SCA"
		// 	email: "test@hello.com"
		// 	refreshToken: "AE0u-Nf-hPw1ApBlTwxkWsHnCwLs9RFxBc1S02mhnSV0wXA1fj3LHrfZoaJTOrseddPN9Ga9jLAkcazWIev8A3onivp8qreTwib6IP9Rk7ssN2JwXWBc7eUOECXso_6cbCpLTG2RHqM66Pkvm-vAz6ZCPfdhCBSW89UQm5f-VXwcgzXRa06rMUm5rGjNOhWwi4QfErJf3XhaRJofyGDBlbd_OEz2z3Mn9A"
		// 	expiresIn: "3600"
		// 	localId: "Te4MZWhpcgTOkI6umkQTkIbbKmv2"
	}

	/**
	 * Api sign in with email and password
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
	public function apiSignIn(array $input)
	{
		// Sign in with email / password
		// https://firebase.google.com/docs/reference/rest/auth#section-sign-in-email-password

		if($input['key'] != $this->Config->get('system-security.api_key'))
		{
			throw new \Exception("Invalid key", 1);
		}

		if($this->Auth->attempt(array('email' => $input['email'], 'password' => $input['password'], 'is_active' => true), false))
		{
			$token = str_random(20);
			$authUser = $this->Auth->user()->toArray();
			$authUser['organization_id'] = $authUser['default_organization'];
			$organization = $this->getOrganization($authUser['default_organization']);
			$authUser['organization_name'] = $organization['name'];
			$authUser['database_connection_name'] = $organization['database_connection_name'];
			$authUser['article_images_folder_id'] = $organization['article_images_folder_id'];
			$authUser['main_gallery_images_folder_id'] = $organization['main_gallery_images_folder_id'];
			$authUser['default_category_id'] = $organization['default_category_id'];
			$authUser['default_article_type_id'] = $organization['default_article_type_id'];
			$authUser['default_increase_movement_type_id'] = $organization['default_increase_movement_type_id'];
			$authUser['default_decrease_movement_type_id'] = $organization['default_decrease_movement_type_id'];
			$authUser['default_warehouse_id'] = $organization['default_warehouse_id'];

			$this->Cache->put($token, json_encode($authUser), $this->Config->get('session.lifetime'));

			return response()->json(
				array(
					'message' => '',
					'idToken' => $token, 
					'refreshToken' => '', 
					'userId' => $authUser['id'], 
					'expiresIn' => $this->Config->get('session.lifetime') * 60, 
					'organizationId' => $authUser['default_organization'], 
					'costPricePrecision' => $organization['cost_price_precision'], 
					'currencySymbol' => $this->getOrganizationCurrencySymbol($authUser['default_organization']), 
					'name' => $authUser['firstname']
				)
			);
		}

		return response()->json(
			array(
				'message' => 'failedAttempt',
				'messageTitle' => $this->Lang->get('security/login.failAuthAttempt'),
				'messageText' => $this->Lang->get('security/login.tryAgain')
			)
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

		if ($this->Auth->attempt(array('email' => $email, 'password' => $password, 'is_active' => true), false))
		{
			if(strpos($intendedUrl, "logout") !== false)
			{
				$intendedUrl = $this->Url->to('/dashboard');
			}

			$authUser = $this->Auth->user()->toArray();

			$this->Session->forget('loggedUser');
			$this->Session->put('loggedUser', json_encode($authUser));

			$this->setLastLoggedUser($authUser);

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

			return json_encode(
				array(
					'message' => 'failedAttempt',
					'messageTitle' => $this->Lang->get('security/login.failAuthAttempt'),
					'messageText' => $this->Lang->get('security/login.tryAgain')
				)
			);
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
		// $this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] User logged out', 'context' => array('email' => $this->getLoggedUserEmail())), $this));

		$this->Log->info('[SECURITY EVENT] User logged out', array('email' => $this->getLoggedUserEmail()));

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
				// $this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User failed to request a password reminder email', 'context' => array('email' => $credentials['email'])), $this));

				$message = 'error';

				$this->Log->warning('[SECURITY EVENT] User failed to request a password reminder email', array('email' => $credentials['email']));

				break;

				// return $this->Redirector->back()->with('error', $this->Lang->get('security/' . $response));

			case PasswordBroker::RESET_LINK_SENT:
				// $this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] User requested a password reminder email', 'context' => array('email' => $credentials['email'])), $this));

				$message = 'status';

				$this->Log->info('[SECURITY EVENT] User requested a password reminder email', array('email' => $credentials['email']));

				break;

				// return $this->Redirector->back()->with('status', $this->Lang->get('security/' . $response));
		}

		return json_encode(
			array(
				$message => $this->Lang->get('security/' . $response)
			)
		);
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
				// $this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] User successfully reset his password', 'context' => array('email' => $credentials['email'])), $this));

				$this->Log->warning('[SECURITY EVENT] User successfully reset his password', array('email' => $credentials['email']));

				return $this->Redirector->to('login');
			default:
				// $this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User failed to reset his password', 'context' => array('email' => $credentials['email'])), $this));

				$this->Log->warning('[SECURITY EVENT] User failed to reset his password', array('email' => $credentials['email']));

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
			// $this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User failed to activate his account', 'context' => array('email' => $credentials['email'], 'errorType' => 'Invalid User')), $this));

			$this->Log->warning('[SECURITY EVENT] User failed to activate his account', array('email' => $credentials['email']));

			return $this->Redirector->back()->with('error', $this->Lang->get('security/' . PasswordBroker::INVALID_USER));
		}

		if($User[0]->activation_code != $credentials['token'])
		{
			// $this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User failed to activate his account', 'context' => array('email' => $credentials['email'], 'errorType' => 'Invalid Token')), $this));

			$this->Log->warning('[SECURITY EVENT] User failed to activate his account', array('email' => $credentials['email']));

			return $this->Redirector->back()->with('error', $this->Lang->get('security/' . PasswordBroker::INVALID_TOKEN));
		}

		if($credentials['password'] != $credentials['password_confirmation'] || !$credentials['password'] || strlen($credentials['password']) < 6)
		{
			// $this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User failed to activate his account', 'context' => array('email' => $credentials['email'], 'errorType' => 'Invalid Password')), $this));

			$this->Log->warning('[SECURITY EVENT] User failed to activate his account', array('email' => $credentials['email']));

			return $this->Redirector->back()->with('error', $this->Lang->get('security/' . PasswordBroker::INVALID_PASSWORD));
		}

		$this->User->update(array('id' => $User[0]->id, 'password' => $this->Hash->make($credentials['password']), 'is_active' => 1, 'activated_at' => Carbon::now(), 'activation_code' => null));

		// $this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] User successfully activated his account', 'context' => array('email' => $credentials['email'])), $this));

		$this->Log->info('[SECURITY EVENT] User successfully activated his account', array('email' => $credentials['email']));

		return $this->Redirector->to('login');
	}

	/**
	 * Finds out if the current user is not logged in (a guest).
	 *
	 * @return true if is not logged (a guest), false otherwise.
	 */
	public function isUserGuest()
	{
		if($this->Session->has('loggedUser'))
		{
			return false;
		}

		return true;
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
	public function setLastLoggedUser(array $authUser)
	{
		$this->Cookie->queue(
			$this->Cookie->forever(
				$this->getLastLoggedUserCookieName(),
				json_encode(
					array(
						'name' => $authUser['firstname'],
						'email' => $authUser['email']
					)
				)
			)
		);
	}

	/**
	 * Unset current user organization
	 *
	 * @return void
	 */
	public function unsetLastLoggedUser()
	{
		$this->Cookie->queue(
			$this->Cookie->forget($this->getLastLoggedUserCookieName())
		);
	}

	/**
	 * Set current user organization
	 *
	 * @return void
	 */
	public function getLastLoggedUser()
	{
		$lastLoggedUser = $this->Input->cookie($this->getLastLoggedUserCookieName());

		if(empty($lastLoggedUser))
		{
			return '';
		}

		return json_decode(
			$lastLoggedUser,
			true
		);
	}

	/**
	 * Set current user organization
	 *
	 * @return void
	 */
	public function getLastLoggedUserName()
	{
		$lastLoggedUser = $this->getLastLoggedUser();

		if(!empty($lastLoggedUser))
		{
			return $lastLoggedUser['name'];
		}

		return '';
	}

	/**
	 * Set current user organization
	 *
	 * @return void
	 */
	public function getLastLoggedUserEmail()
	{
		$lastLoggedUser = $this->getLastLoggedUser();

		if(!empty($lastLoggedUser))
		{
			return $lastLoggedUser['email'];
		}

		return '';
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
	 * Get logged user
	 *
	 * @return int
	 */
	public function getApiLoggedUser($token, $throwExceptionIfInvalid = true)
	{
		if(empty($token))
		{
			if($throwExceptionIfInvalid)
			{
				throw new \Exception("Empty token", 1);
			}

			return '';
		}

		if($token == $this->Config->get('system-security.demo_api_token'))
		{
			return $this->Config->get('system-security.demo_api_user');
		}

		if( !empty( $this->Config->get('system-security.api_preset_tokens') ) && is_array( $this->Config->get('system-security.api_preset_tokens') ) )
		{
			$apiPresetTokens = $this->Config->get('system-security.api_preset_tokens');

			if( isset( $apiPresetTokens[$token] ) )
			{
				return $apiPresetTokens[$token];
			}
		}

		if($this->Cache->has($token))
		{
			return  json_decode($this->Cache->get($token), true);
		}
		
		if($throwExceptionIfInvalid)
		{
			throw new \Exception("Invalid token", 1);
		}

		return '';
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
	}

	/**
	* Get organization connection
	*
	* @param  int $value organization id
	*
	* @return string
	*/
	public function getOrganization($organizationId)
	{
		if($this->Cache->has('organization' . $organizationId))
		{
			$organization = json_decode($this->Cache->get('organization' . $organizationId), true);
		}
		else
		{
			$Organization = $this->Organization->byId($organizationId);

			if(empty($Organization))
			{
				return '';
			}

			$organization = $Organization->toArray();

			$this->Cache->put('organization' . $organizationId, json_encode($organization), 360);
		}

		return $organization;
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
	public function getOrganizationCurrencySymbol($organizationId)
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

	/**
	* Get organization by api token
	*
	* @param  int $value organization id
	*
	* @return string
	*/
	public function getOrganizationByApiToken($token)
	{
		if($this->Cache->has($token))
		{
			return json_decode($this->Cache->get($token), true);
		}

		$Organizations = $this->Organization->byApiToken($token);

		if($Organizations->isEmpty())
		{
			throw new \Exception("Invalid key", 1);
			// return '';
		}

		$organization = $Organizations->first()->toArray();

		$this->Cache->put($token, json_encode($organization), $this->Config->get('session.lifetime'));

		return $organization;
	}

	/**
	* Get organization by id with api key validation
	*
	* @param  int $value organization id
	*
	* @return string
	*/
	public function getOrganizationByIdWithApiKeyValidation($id, $key)
	{
		if($key != $this->Config->get('system-security.api_key'))
		{
			throw new \Exception("Invalid key", 1);
		}

		$organization = $this->getOrganization($id);

		if(empty($organization))
		{
			throw new \Exception("Invalid id", 1);
		}

		return $organization;
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
	}

	/**
	* Get current user organization commercial trade
	*
	* @return string
	*/
	public function getCurrentUserOrganizationCommercialTrade()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return '';
		}
		else
		{
			return $organization['commercial_trade'];
		}
	}

	/**
	* Get current user organization commercial trade
	*
	* @return string
	*/
	public function getCurrentUserOrganizationAddress()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return '';
		}
		else
		{
			return (!empty($organization['street1'])?$organization['street1'] . ', ':'') .
				(!empty($organization['street2'])?$organization['street2'] . ', ':'') .
				(!empty($organization['city_name'])?$organization['city_name'] . ', ':'') .
				(!empty($organization['state_name'])?$organization['state_name']:'');
		}
	}


	/**
	* Get current user organization commercial trade
	*
	* @return string
	*/
	public function getCurrentUserOrganizationPhoneNumber()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return '';
		}
		else
		{
			return $organization['phone_number'];
		}
	}


	/**
	* Get current user organization commercial trade
	*
	* @return string
	*/
	public function getCurrentUserOrganizationEmail()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return '';
		}
		else
		{
			return $organization['email'];
		}
	}

	/**
	* Get current user organization commercial trade
	*
	* @return string
	*/
	public function getCurrentUserOrganizationWebSite()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return '';
		}
		else
		{
			return $organization['web_site'];
		}
	}

	/**
	* Get current user organization commercial trade
	*
	* @return string
	*/
	public function getCurrentUserOrganizationCompanyRegistration()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return '';
		}
		else
		{
			return $organization['company_registration'];
		}
	}

	/**
	* Get current user organization commercial trade
	*
	* @return string
	*/
	public function getCurrentUserOrganizationTaxId()
	{
		$organization = $this->getSessionOrganization();

		if(empty($organization))
		{
			return '';
		}
		else
		{
			return $organization['tax_id'];
		}
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
	}

	/**
	* Get current user organization cost price precision
	*
	* @return string
	*/
	public function getCurrentUserOrganizationCostPricePrecision($organizationId = null)
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

		return $user['timezone'];
	}

	/**
	 * Get logged user dashboard custom view
	 *
	 * @return string
	 */
	public function getLoggedUserDashboardCustomView()
	{
		if ($this->isUserGuest())
		{
			return '';
		}

		$user = $this->getSessionLoggedUser();

		return $user['dashboard_custom_view'];
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
	 * Get the name of the cookie used to store the current organization id.
	 *
	 * @return string
	 */
	public function getLastLoggedUserCookieName()
	{
		return 'last_logged_user_'.md5(get_class($this));
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

	/**
	* Get logged user default warehouse
	*
	* @return array
	*/
	public function getLoggedUserDefaultWarehouse()
	{
		if ($this->isUserGuest())
		{
			return '';
		}

		$user = $this->getSessionLoggedUser();

		return array(
			'warehouse_id' => $user['default_warehouse_id'],
			'warehouse_name' => $user['default_warehouse_name']
		);
	}

	/**
	 * Get token data
	 * Compatibilidad con Decima v2.0
	 *
	 * @return array
	 */
	public function getTokenData()
	{
		return false;
	}
}

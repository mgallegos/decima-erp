<?php
/**
 * @file
 * User Manager Service.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Services\UserManagement;

use Illuminate\Validation\Factory;

use Illuminate\Mail\Mailer;

use Illuminate\Routing\UrlGenerator;

use Illuminate\Log\Writer;

use Illuminate\Config\Repository;

use Illuminate\Database\DatabaseManager;

use Illuminate\Contracts\Hashing\Hasher;

use Illuminate\Translation\Translator;

use Illuminate\Cache\CacheManager;

use Illuminate\Session\SessionManager;

use DateTimeZone;

use Exception;

use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface;

use App\Kwaai\System\Services\Validation\AbstractLaravelValidator;

use App\Kwaai\Security\Repositories\User\EloquentAdminUserGridRepository;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Kwaai\Security\Repositories\Journal\JournalInterface;

use App\Kwaai\Security\Repositories\Permission\PermissionInterface;

use App\Kwaai\Security\Repositories\Role\RoleInterface;

use App\Kwaai\Security\Repositories\Menu\MenuInterface;

use App\Kwaai\Security\Repositories\Module\ModuleInterface;

use App\Kwaai\Organization\Repositories\Organization\OrganizationInterface;

use App\Kwaai\Security\Repositories\User\UserInterface;

use App\Kwaai\Security\Repositories\User\EloquentUserGridRepository;

use App\Kwaai\Security\Services\UserManagement\UserManagementInterface;

use Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface;

class UserManager extends AbstractLaravelValidator implements UserManagementInterface{

	/**
	 * User
	 *
	 * @var App\Kwaai\Security\Repositories\User\UserInterface
	 *
	 */
	protected $User;

	/**
	 * Organization
	 *
	 * @var App\Kwaai\Security\Repositories\Organization\OrganizationInterface
	 *
	 */
	protected $Organization;

	/**
	 * Module
	 *
	 * @var App\Kwaai\Organization\Repositories\Module\ModuleInterface
	 *
	 */
	protected $Module;

	/**
	 * Menu
	 *
	 * @var App\Kwaai\Security\Repositories\Menu\MenuInterface
	 *
	 */
	protected $Menu;

  /**
   * Role
   *
   * @var App\Kwaai\Security\Repositories\Role\RoleInterface
   *
   */
  protected $Role;

  /**
   * Permission
   *
   * @var App\Kwaai\Security\Repositories\Permission\PermissionInterface
   *
   */
  protected $Permission;

  /**
   * Journal
   *
   * @var App\Kwaai\Security\Repositories\Journal\JournalInterface
   *
   */
  protected $Journal;

	/**
	 * Grid Encoder
	 *
	 * @var Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface
	 *
	 */
	protected $GridEncoder;

	/**
	 * Eloquent User Repository
	 *
	 * @var App\Kwaai\Security\Repositories\User\EloquentUserGridRepository
	 *
	 */
	protected $EloquentUserGridRepository;

	/**
	 * Eloquent Admin User Repository
	 *
	 * @var App\Kwaai\Security\Repositories\User\EloquentAdminUserGridRepository
	 *
	 */
	protected $EloquentAdminUserGridRepository;

	/**
	 * Laravel Database Manager
	 *
	 * @var Illuminate\Database\DatabaseManager
	 *
	 */
	protected $DB;

	/**
	 * Authentication Management Interface
	 *
	 * @var App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface
	 *
	 */
	protected $AuthenticationManager;

	/**
	 * Journal Management Interface
	 *
	 * @var App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface
	 *
	 */
	protected $JournalManager;

	/**
	 * Laravel Translator instance
	 *
	 * @var Illuminate\Translation\Translator
	 *
	 */
	protected $Lang;

	/**
	 * Laravel Translator instance
	 *
	 * @var Illuminate\Translation\Translator
	 *
	 */
	protected $Hash;

	/**
	 * Laravel Repository instance
	 *
	 * @var Illuminate\Config\Repository
	 *
	 */
	protected $Config;

	/**
	 * The URL generator instance
	 *
	 * @var \Illuminate\Routing\UrlGenerator
	 *
	 */
	protected $Url;

	/**
	 * Mailer
	 *
	 * @var Illuminate\Mail\Mailer
	 */
	protected $Mailer;

	/**
   * Laravel Writer (Log)
   *
   * @var Illuminate\Log\Writer
   *
   */
  protected $Log;

	/**
	 * Laravel Validator
	 *
	 * @var Illuminate\Validation\Factory
	 *
	 */
	protected $Validator;

	/**
	 * Laravel Cache instance
	 *
	 * @var \Illuminate\Cache\CacheManager
	 *
	 */
	protected $Cache;

	/**
	 * Laravel Session instance
	 *
	 * @var \Illuminate\Session\SessionManager
	 *
	 */
	protected $Session;

	/**
	 * The hashing key.
	 *
	 * @var string
	 */
	protected $hashKey;

	/**
	* Validation rules
	*
	* @var Array
	*/
	protected $rules;

	/**
	 * Validation messages
	 *
	 * @var Array
	 */
	protected $messages;

	public function __construct(
		UserInterface $User,
		OrganizationInterface  $Organization,
		ModuleInterface $Module,
		MenuInterface $Menu,
		RoleInterface $Role,
		PermissionInterface $Permission,
		JournalInterface $Journal,
		AuthenticationManagementInterface $AuthenticationManager,
		JournalManagementInterface $JournalManager,
		RequestedDataInterface $GridEncoder,
		EloquentUserGridRepository $EloquentUserGridRepository,
		EloquentAdminUserGridRepository $EloquentAdminUserGridRepository,
		DateTimeZone $DateTimeZone,
		DatabaseManager $DB,
		Translator $Lang,
		Hasher $Hash,
		Repository $Config,
		UrlGenerator $Url,
		Mailer $Mailer,
		Writer $Log,
		Factory $Validator,
		CacheManager $Cache,
		SessionManager $Session,
		$hashKey
	)
	{
		$this->User = $User;

		$this->Organization = $Organization;

		$this->Module = $Module;

		$this->Menu = $Menu;

    $this->Role = $Role;

    $this->Permission = $Permission;

    $this->Journal = $Journal;

		$this->GridEncoder = $GridEncoder;

		$this->EloquentUserGridRepository = $EloquentUserGridRepository;

		$this->EloquentAdminUserGridRepository = $EloquentAdminUserGridRepository;

		$this->DateTimeZone = $DateTimeZone;

		$this->DB = $DB;

		$this->AuthenticationManager = $AuthenticationManager;

		$this->JournalManager = $JournalManager;

		$this->Lang = $Lang;

		$this->Hash = $Hash;

		$this->Config = $Config;

		$this->Url = $Url;

		$this->Mailer = $Mailer;

		$this->Log = $Log;

		$this->Validator = $Validator;

		$this->Cache = $Cache;

		$this->Session = $Session;

		$this->hashKey = $hashKey;

		$this->rules = array(
			'email' => 'required|email',
			'password' => 'min:6|same:confirm_password'
		);

		$this->messages = array(
			'email.email' => $this->Lang->get('security/user-management.invalidEmailInfoMessage'),
			'password.min' => $this->Lang->get('security/user-management.passwordsMinLengthInfoMessage'),
			'password.same' => $this->Lang->get('security/user-management.passwordsDoNotMatchInfoMessage')
		);
	}

	/**
	 * Create a new user.
	 *
	 * @param array $input
	 *	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'password'=>$password, 'is_active'=>$is_active, 'created_by'=>$created_by);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success (non-admin user): {"success":security/user-management.successSaveMessage}
	 *  In case of success (admin user): {"success":form.defaultSuccessSaveMessage}
	 *  In case of a non-admin user tries to add an admin user: {"info":security/user-management.nonAdminException}
	 *  In case of an existing user: {"info":security/user-management.UserExistsException}
	 *  In form does not pass validation: {"validationFailed":true, "fieldValidationMessages":{$field0:$message0, $field1:$message1,…}}
	 */
	public function save(array $input)
	{
		$data = array(
			'email' => $input['email'],
			'password' => $input['password'],
			'confirm_password' => $input['confirm_password']
		);

		if( $this->with( $data )->fails() )
		{
			return json_encode(array('validationFailed' => true , 'fieldValidationMessages' => $this->singleMessageStringByField()));
		}

		if(!$this->User->byEmail($input['email'])->isEmpty())
		{
			return json_encode(array('validationFailed' => true , 'fieldValidationMessages' => array('email' => $this->Lang->get('security/user-management.UserExistsException'))));
		}

		if(!$this->AuthenticationManager->isUserAdmin() && $input['is_admin'] == '1')
		{
			// $this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] A non-admin user tried to add an admin user', 'context' => $input), $this->AuthenticationManager));

			$this->Log->warning('[SECURITY EVENT] A non-admin user tried to add an admin user', $input);

			return json_encode(array('info' => $this->Lang->get('security/user-management.nonAdminException')));
		}

		if(empty($input['password']))
		{
			$input['password'] = bcrypt(str_random(6));
		}
		else
		{
			$input['password'] = bcrypt($input['password']);
		}

		if($input['send_email'] == '1')
		{
			$input['is_active'] = 0;
			$email = $input['email'];
			$value = str_shuffle(sha1($email.spl_object_hash($this).microtime(true)));
			$input['activation_code'] = hash_hmac('sha1', $value, $this->hashKey);
			$sender = $this->AuthenticationManager->getLoggedUserFirstname() . ' ' . $this->AuthenticationManager->getLoggedUserLastname();
			$subject = $this->Lang->get('security/user-activation.emailSubject', array('systemName' => $this->Config->get('system-security.system_name')));
		}
		else
		{
			$input['activation_code'] = null;
			$input['is_active'] = 1;
		}

		$input = array_add($input, 'created_by', $this->AuthenticationManager->getLoggedUserId());
		$input = array_add($input, 'default_organization', $this->AuthenticationManager->getCurrentUserOrganization('id'));

		$this->DB->transaction(function() use ($input)
		{
			if($input['is_admin'] == '1')
			{
				$input['default_organization'] = null;
				$User = $this->User->create($input);
        $Journal = $this->Journal->create(array('journalized_id' => $User->id, 'journalized_type' => $this->User->getTable(), 'user_id' => $input['created_by']));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.adminUserAddedJournal', array('email' => $input['email'], 'organization' => $this->AuthenticationManager->getCurrentUserOrganization('name')))), $Journal);
				$data = $input;

				unset($data['password'], $data['activation_code']);

				// $this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] A new admin user has been added to the system', 'context' => $data), $this->AuthenticationManager));

				$this->Log->info('[SECURITY EVENT] A new admin user has been added to the system', $data);
			}
			else
			{
				$input['is_admin'] = '0';
        $User = $this->User->create($input);
        $this->User->attachOrganizations($User->id, array($input['default_organization']), $input['created_by'], $User);
        $Journal = $this->Journal->create(array('journalized_id' => $User->id, 'journalized_type' => $this->User->getTable(), 'user_id' => $input['created_by'], 'organization_id' => $input['default_organization']));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.userAddedJournal', array('email' => $input['email'], 'organization' => $this->AuthenticationManager->getCurrentUserOrganization('name')))), $Journal);
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.userAddedSystemJournal', array('email' => $input['email'], 'organization' => $this->AuthenticationManager->getCurrentUserOrganization('name')))), $Journal);
				$data = $input;

				unset($data['password'], $data['activation_code']);

				// $this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] A new user has been added to the organization', 'context' => $data), $this->AuthenticationManager));

				$this->Log->info('[SECURITY EVENT] A new user has been added to the organization', $data);
			}

		});

		if($input['send_email'] == '1')
		{
			$replyToEmail = $this->Config->get('system-security.reply_to_email');
			$replyToName = $this->Config->get('system-security.reply_to_name');

			$this->Mailer->queue('security.emails.activation', array('addressee' => $input['firstname'], 'sender' => $sender, 'token' => $input['activation_code']), function($message) use ($input, $subject, $replyToEmail, $replyToName)
			{
				$message->to($input['email'])->subject($subject)->replyTo($replyToEmail, $replyToName);
			});
		}

		if($input['is_admin'] == '1')
		{
			return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
		}
		else
		{
			return json_encode(array('success' => $this->Lang->get('security/user-management.successSaveMessage')));
		}
	}

	/**
	 * Update an existing user.
	 *
	 * @param array $input
	 *	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'password'=>$password, 'is_active'=>$is_active);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessUpdateMessage}
	 *  In passwords do not match: {"info":form.defaultSuccessUpdateMessage}
	 *  If user is not root and tries to update a user that has not been created by him: {"info":form.defaultSuccessUpdateMessage}
	 *  In form does not pass validation: {"validationFailed":true, "fieldValidationMessages":{$field0:$message0, $field1:$message1,…}}
	 */
	public function update(array $input)
	{
		$data = array(
			'email' => $input['email'],
			'password' => $input['password'],
			'confirm_password' => $input['confirm_password']
		);

		if( $this->with( $data )->fails() )
		{
			return json_encode(array('validationFailed' => true , 'fieldValidationMessages' => $this->singleMessageStringByField()));
		}

		$loggedUserId = $this->AuthenticationManager->getLoggedUserId();

		if(!isset($input['id']))
		{
			$input['id'] = $loggedUserId;
		}

		$User = $this->User->byId($input['id']);

		if($User->email != $input['email'] && !$this->User->byEmail($input['email'])->isEmpty())
		{
			return json_encode(array('validationFailed' => true , 'fieldValidationMessages' => array('email' => $this->Lang->get('security/user-management.UserExistsException'))));
		}

		if(!$this->AuthenticationManager->isUserRoot() && $input['id'] != $loggedUserId)
		{
			// $this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User tried to update a user that has not been created by him', 'context' => $input), $this->AuthenticationManager));

			$this->Log->warning('[SECURITY EVENT] User tried to update a user that has not been created by him', $input);

			return json_encode(array('info' => $this->Lang->get('security/user-management.userCreatedByInfoMessage')));
		}

		if(!empty($input['password']) && ($input['password'] != $input['confirm_password']))
		{
			return json_encode(array('info' => $this->Lang->get('security/user-management.passwordsDoNotMatchInfoMessage')));
		}

		if(!empty($input['password']))
		{
			//$input['password'] = $this->Hash->make($input['password']);
			$input['password'] = bcrypt($input['password']);
		}
    else
    {
      unset($input['password']);
    }

		if(!$this->AuthenticationManager->isUserRoot() && $loggedUserId != $input['id'])
		{
			unset($input['password']);
		}

		unset(
			$input['_token'],
			$input['send_email'],
			$input['is_admin'],
			$input['confirm_password'],
			$input['organizacion_name']
		);

		$this->Session->forget('loggedUser');

    $this->DB->transaction(function() use ($User, $input, $loggedUserId)
    {
        $unchangedUserValues = $User->toArray();
        $unchangedUserValues['password'] = '';

        $this->User->update($input, $User);

        $diff = 0;

        $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

				if($organizationId == -1)
				{
					$organizationId = null;
				}

        foreach ($input as $key => $value)
        {
          if($unchangedUserValues[$key] != $value)
          {
            $diff++;

            if($diff == 1)
            {
	            if(empty($organizationId))
	            {
	              $Journal = $this->Journal->create(array('journalized_id' => $input['id'], 'journalized_type' => $this->User->getTable(), 'user_id' => $loggedUserId));
	            }
	            else
	            {
	              $Journal = $this->Journal->create(array('journalized_id' => $input['id'], 'journalized_type' => $this->User->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
	            }
            }

						if($key == 'default_organization')
						{
							$oldOrganization = $this->Organization->byId($unchangedUserValues[$key]);
							$newOrganization = $this->Organization->byId($value);
							$this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('security/user-management.' . camel_case($key)), 'field_lang_key' => 'security/user-management.' . camel_case($key), 'old_value' => $oldOrganization->name, 'new_value' => $newOrganization->name), $Journal);
						}
						else if($key == 'is_active')
						{
								$this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('security/user-management.' . camel_case($key)), 'field_lang_key' => 'security/user-management.' . camel_case($key), 'old_value' => $this->Lang->get('journal.' . $unchangedUserValues[$key]), 'new_value' => $this->Lang->get('journal.' . $value)), $Journal);
						}
          	else if($key != 'password')
            {
                $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('security/user-management.' . camel_case($key)), 'field_lang_key' => 'security/user-management.' . camel_case($key), 'old_value' => $unchangedUserValues[$key], 'new_value' => $value), $Journal);
            }
          }
        }

        if(isset($input['password']) && !empty($input['password']))
        {
          $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('security/user-management.password'), 'field_lang_key' => 'security/user-management.password', 'old_value' => '**********', 'new_value' => '**********'), $Journal);
        }
    });

		return json_encode(array('success' => $this->Lang->get('form.defaultSuccessUpdateMessage')));
	}

	/**
	* Update an existing user.
	*
	* @param array $input
	*	An array as follows: array('multiple_organization_popover_shown'=>$multipleOrganizationPopoverShown, 'popovers_shown'=>$popoversShown);
	*
	* @return void
	*/
	public function updateloggedUserPopoverStatus(array $input)
	{
		unset($input['_token']);
		$input['id'] = $this->AuthenticationManager->getLoggedUserId();
		$this->User->update($input);
		$this->Session->forget('loggedUser');
	}


	/**
	 * Remove user from organization and soft-delete those non-admin users that are not associated to any other organization.
	 *
	 * @param array $input
	 * 	An array as follows: array($id0, $id1,…);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success and one user has been removed: {"success":security/user-management.successDeletedUserMessage}
	 *  In case of success and more than one user has been removed: {"success":security/user-management.successDeletedUsersMessage}
	 */
	public function delete(array $input)
	{
		$count = 0;

		$this->DB->transaction(function() use ($input, &$count)
		{
			$loggedUserId = $this->AuthenticationManager->getLoggedUserId();
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
      $organizationName = $this->AuthenticationManager->getCurrentUserOrganization('name');

			foreach ($input['id'] as $key => $id)
			{
				$count++;

				$User = $this->User->byId($id);

				if($this->AuthenticationManager->isUserRoot($id))
				{
					$input['email'] = $User->email;

					// $this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User tried to delete a root user', 'context' => $input), $this->AuthenticationManager));

					$this->Log->warning('[SECURITY EVENT] User tried to delete a root user', $input);

					throw new Exception($this->Lang->get('security/user-management.rootException'));
				}

				$this->User->detachOrganizations($id, array($this->AuthenticationManager->getCurrentUserOrganization('id')));

        $Journal = $this->Journal->create(array('journalized_id' => $id, 'journalized_type' => $this->User->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.userDeletedJournal', array('email' => $User->email, 'organization' => $organizationName))), $Journal);

        $countUserOrganization = $this->getCountUserOrganizations($id);

				if($User->default_organization == $this->AuthenticationManager->getCurrentUserOrganization('id'))
				{
					if($countUserOrganization > 0)
					{
            $this->setFirstOrganizationAvailableToUser($User, $Journal, $organizationName);
					}
					else
					{
            $this->deactivateUser($User, $Journal, $organizationName);
					}
				}

				if($countUserOrganization == 0 && !$this->AuthenticationManager->isUserAdmin($id, $User))
				{
          $this->User->delete(array($id));
				}
			}
		});

		if($count == 1)
		{
			return json_encode(array('success' => $this->Lang->get('security/user-management.successDeletedUserMessage')));
		}
		else
		{
			return json_encode(array('success' => $this->Lang->get('security/user-management.successDeletedUsersMessage')));
		}
	}

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
	public function addUserToOrganization(array $input)
	{
		$this->DB->transaction(function() use ($input, &$User, &$organizationName)
		{
			$this->User->restore($input['id']);
      $User = $this->User->byId($input['id']);

      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
      $organizationName = $this->AuthenticationManager->getCurrentUserOrganization('name');

			$this->User->attachOrganizations($input['id'], array($organizationId), $loggedUserId);

			$this->Cache->forget('userOrganizations' . $input['id']);
			$this->Cache->forget('userOrganizationCount' . $input['id']);

      $Journal = $this->Journal->create(array('journalized_id' => $input['id'], 'journalized_type' => $this->User->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.userAddedJournal', array('email' => $User->email, 'organization' => $organizationName))), $Journal);

      if(empty($User->default_organization))
      {
      	$this->User->update(array('id' => $input['id'], 'default_organization' => $organizationId), $User);
      	$this->Journal->attachDetail($Journal->id, array('field' => 'security/user-management.defaultOrganization', 'field_lang_key' => 'security/user-management.defaultOrganization', 'new_value' => $organizationName), $Journal);
      }

			if($this->AuthenticationManager->isUserAdmin($input['id'], $User))
			{
				$this->User->attachMenus($input['id'], $this->Config->get('system-security.admin_apps_id'), true, $organizationId, $loggedUserId, $User);
				$this->User->attachPermissions($input['id'], $this->Config->get('system-security.admin_permissions_id'), true, $organizationId, $loggedUserId, $User);
			}
		});

		unset($input['id']);

		$input['email'] = $User->email;

		// $this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] A new user has been added to the organization', 'context' => $input), $this->AuthenticationManager));

		$this->Log->info('[SECURITY EVENT] A new user has been added to the organization', $input);

		if($this->Config->get('system-security.email_organization_user'))
		{
			$sender = $this->AuthenticationManager->getLoggedUserFirstname() . ' ' . $this->AuthenticationManager->getLoggedUserLastname();
			$subject = $this->Lang->get('security/new-organization-user.emailSubject', array('systemName' => $this->Config->get('system-security.system_name'), 'organizationName' => $organizationName));

			$replyToEmail = $this->Config->get('system-security.reply_to_email');
			$replyToName = $this->Config->get('system-security.reply_to_name');

			$this->Mailer->queue('security.emails.new-organization-user', array('addressee' => $User->firstname, 'sender' => $sender, 'organizationName' => $organizationName), function($message) use ($User, $subject, $replyToEmail, $replyToName)
			{
				$message->to($User->email)->subject($subject)->replyTo($replyToEmail, $replyToName);
			});
		}

		return json_encode(array('success' => $this->Lang->get('security/user-management.successAddedUserToOrganizationMessage')));
	}

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
	public function setUserAsAdmin(array $input)
	{
		unset($input['_token']);

		$input['is_admin'] = true;
		$input['deleted_at'] = null;
		$input['is_active'] = true;

		$this->DB->transaction(function() use (&$input)
		{
			$User = $this->User->byId($input['id']);
			$this->User->update($input, $User);

			$loggedUserId = $this->AuthenticationManager->getLoggedUserId();

			$this->User->organizationByUser($input['id'])->each(function($Organization) use($input, $loggedUserId, $User)
			{
				$this->User->attachMenus($input['id'], $this->Config->get('system-security.admin_apps_id'), true, $Organization->id, $loggedUserId, $User);
				$this->User->attachPermissions($input['id'], $this->Config->get('system-security.admin_permissions_id'), true, $Organization->id, $loggedUserId, $User);
			});

  		$Journal = $this->Journal->create(array('journalized_id' => $User->id, 'journalized_type' => $this->User->getTable(), 'user_id' => $loggedUserId));
  		$this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.adminUserAddedJournal', array('email' => $User->email))), $Journal);

			$input['email'] = $User->email;
		});

		// $this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] A new admin user has been added to the system', 'context' => $input), $this->AuthenticationManager));

		$this->Log->info('[SECURITY EVENT] A new admin user has been added to the system', $input);

		return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
	}

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
	public function setUserAsNonAdmin(array $input)
	{
		$count = 0;

		$this->DB->transaction(function() use (&$input, &$count)
		{
			$loggedUserId = $this->AuthenticationManager->getLoggedUserId();

			foreach ($input['id'] as $key => $id)
			{
				$count++;

				$User = $this->User->byId($id);

				if($this->AuthenticationManager->isUserRoot($id))
				{
					$input['email'] = $User->email;

					// $this->Event->fire(new OnNewWarningMessage(array('message' => '[SECURITY EVENT] User tried to set a root user as non-admin', 'context' => $input), $this->AuthenticationManager));

					$this->Log->warning('[SECURITY EVENT] User tried to set a root user as non-admin', $input);

					throw new Exception($this->Lang->get('security/user-management.rootException'));
				}

				$this->User->update(array('id' => $id, 'is_admin' => false), $User);

				$this->User->organizationByUser($id)->each(function($Organization) use($id, $loggedUserId, $User)
				{
					$this->User->attachMenus($id, $this->Config->get('system-security.admin_apps_id'), false, $Organization->id, $loggedUserId, $User);
					$this->User->attachPermissions($id, $this->Config->get('system-security.admin_permissions_id'), false, $Organization->id, $loggedUserId, $User);
				});

	  		$Journal = $this->Journal->create(array('journalized_id' => $User->id, 'journalized_type' => $this->User->getTable(), 'user_id' => $loggedUserId));
	  		$this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.nonAdminUserAddedJournal', array('email' => $User->email))), $Journal);

				// $this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] An existing admin user has been set as non-admin.', 'context' => array('email' => $User->email)), $this->AuthenticationManager));

				$this->Log->info('[SECURITY EVENT] An existing admin user has been set as non-admin.', array('email' => $User->email));
			}

		});

		if($count == 1)
		{
			return json_encode(array('success' => $this->Lang->get('security/user-management.successNonAdminUserMessage')));
		}
		else
		{
			return json_encode(array('success' => $this->Lang->get('security/user-management.successNonAdminUsersMessage')));
		}
	}

	/**
	 * Set first organization available to user
	 *
	 * @param App\Kwaai\Security\User $User
	 * @param App\Kwaai\Security\Journal $Journal
	 * @param string $organizationName
	 *
	 * @return void
	 */
	public function setFirstOrganizationAvailableToUser($User, $Journal, $organizationName = null, $organizationsExcludedIds = array(-1))
	{
		if(empty($organizationName))
		{
			$Organization = $this->Organization->byId($User->default_organization);

			$organizationName = $Organization->name;
		}

		$organization = $this->getFirstUserOrganizations($User->id, $organizationsExcludedIds);//var_dump($organization);die();

		$this->User->update(array('id' => $User->id, 'default_organization' => $organization['id']), $User);

		$this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('security/user-management.defaultOrganization'), 'field_lang_key' => 'security/user-management.defaultOrganization', 'old_value' => $organizationName, 'new_value' => $organization['name']), $Journal);
	}

	/**
	 * Deactivate user.
	 *
	 * @param App\Kwaai\Security\User $User
	 * @param App\Kwaai\Security\Journal $Journal
	 * @param string $organizationName
	 *
	 * @return void
	 */
	public function deactivateUser($User, $Journal, $organizationName = null)
	{
		if(empty($organizationName))
		{
			$Organization = $this->Organization->byId($User->default_organization);

			$organizationName = $Organization->name;
		}

		if($this->AuthenticationManager->isUserAdmin($User->id, $User))
		{
			$this->User->update(array('id' => $User->id, 'default_organization' => null), $User);
			$this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('security/user-management.defaultOrganization'), 'field_lang_key' => 'security/user-management.defaultOrganization', 'old_value' => $organizationName), $Journal);
		}
		else
		{
			$this->User->update(array('id' => $User->id, 'default_organization' => null, 'is_active' => false), $User);
			$this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.userDeactivatedJournal', array('email' => $User->email, 'organization' => $organizationName))), $Journal);
			$this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('security/user-management.defaultOrganization'), 'field_lang_key' => 'security/user-management.defaultOrganization', 'old_value' => $organizationName), $Journal);
			$this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('security/user-management.isActive'), 'field_lang_key' => 'security/user-management.isActive', 'old_value' => $this->Lang->get('security/user-management.1'), 'new_value' => $this->Lang->get('security/user-management.0')), $Journal);
		}
	}


	/**
	 * Save user roles.
	 *
	 * @param array $post
	 * 	An array as follows: array("rolesId" => array($id0, $id1), "selected" => true|false, "userId"=>$userId, "menuOptionModuleId"=>$menuOptionModuleId,"permissionsModuleId"=>$permissionsModuleId);
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
	public function saveRoles(array $post)
	{
		$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

		$this->DB->transaction(function() use ($organizationId, $post, &$userMenus, &$userModuleMenus, &$permissionModuleMenus, &$menuPermissions, &$userPermissions)
		{
  		$loggedUserId = $this->AuthenticationManager->getLoggedUserId();

			$User = $this->User->byId($post['userId']);

			$Journal = $this->Journal->create(array('journalized_id' => $post['userId'], 'journalized_type' => $this->User->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));

			$this->Cache->forget('userActions' . $post['userId'] . $organizationId);
			$this->Cache->forget('userApps' . $post['userId'] . $organizationId);

			if($post['selected'])
			{
				$this->User->attachRoles($post['userId'], $post['rolesId'], $loggedUserId, $organizationId, $User);

        $this->Role->rolesById($post['rolesId'])->each(function($Role) use($Journal, $User)
        {
          $roleName = $this->Lang->has($Role->lang_key) ? $this->Lang->get($Role->lang_key) : $Role->name;
          $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.rolAssignedJournal', array('rol' => $roleName, 'email' => $User->email))), $Journal);
        });
			}
			else
			{
				$this->User->detachRoles($post['userId'], $post['rolesId'], $User);

        $this->Role->rolesById($post['rolesId'])->each(function($Role) use($Journal, $User)
        {
          $roleName = $this->Lang->has($Role->lang_key) ? $this->Lang->get($Role->lang_key) : $Role->name;
          $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.rolUnassignedJournal', array('rol' => $roleName, 'email' => $User->email))), $Journal);
        });
			}

			if($post["menuOptionModuleId"] == $post["permissionsModuleId"])
			{
				$userMenus = $userMenusPermissionModule = $this->getUserMenusByModule($post["userId"], $post["menuOptionModuleId"], $organizationId);
				$userModuleMenus = $permissionModuleMenus = $this->getMenusByModule($post["menuOptionModuleId"]);
			}
			else
			{
				$userMenus = $this->getUserMenusByModule($post["userId"], $post["menuOptionModuleId"], $organizationId);
				$userMenusPermissionModule = $this->getUserMenusByModule($post["userId"], $post["permissionsModuleId"], $organizationId);
				$userModuleMenus = $this->getMenusByModule($post["menuOptionModuleId"]);
				$permissionModuleMenus = $this->getMenusByModule($post["permissionsModuleId"]);
			}

			foreach ($permissionModuleMenus as $key => $menu)
			{
				if(!isset($userMenusPermissionModule[$menu['value']]))
				{
					unset($permissionModuleMenus[$key]);
				}
			}

			$permissionModuleMenus = array_merge(array(), $permissionModuleMenus);

			if(isset($permissionModuleMenus[0]['value']))
			{
				$menuPermissions = $this->getPermissionsByMenus($permissionModuleMenus[0]['value']);
				$userPermissions = $this->getUserPermissionByMenuAndByOrganization($post["userId"], $permissionModuleMenus[0]['value'], $organizationId);
			}
			else
			{
				$menuPermissions = $userPermissions = array();
			}
		});

		return json_encode(array('userMenus' => $userMenus, 'userModuleMenus' => $userModuleMenus, 'permissionModuleMenus' => $permissionModuleMenus, 'menuPermissions' => $menuPermissions, 'userPermissions' => $userPermissions));
	}

	/**
	 * Save user menus.
	 *
	 * @param array $post
	 * 	An array as follows: array("menusId" => array($id0, $id1), "selected" => true|false, "userId"=>$userId, "permissionsModuleId"=>$permissionsModuleId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  {
	 *  	permissionModuleMenus: [{label: $menuName0, value:$menuId0}, {label: $menuName1, value:$menuId1},���]
	 *  	menuPermissions: [{value:$permissionId0, text: $permissionName0}, {value:$permissionId0, text: $permissionName0},…]
	 *  	userPermissions: {$permissionId0:$permissionName0, $permissionId1:$permissionName1,…}
	 *  }
	 */
	public function saveMenus(array $post)
	{
		$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

		$this->DB->transaction(function() use ($organizationId, $post, &$permissionModuleMenus, &$menuPermissions, &$userPermissions)
		{
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();

      $User = $this->User->byId($post['userId']);
			$this->User->attachMenus($post['userId'], $post['menusId'], $post['selected'], $organizationId, $this->AuthenticationManager->getLoggedUserId(), $User);

      $Journal = $this->Journal->create(array('journalized_id' => $post['userId'], 'journalized_type' => $this->User->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));

			$this->Cache->forget('userActions' . $post['userId'] . $organizationId);
			$this->Cache->forget('userApps' . $post['userId'] . $organizationId);

      $this->Menu->menusById($post['menusId'])->each(function($Menu) use($Journal, $User, $post)
      {
        $appName = $this->Lang->has($Menu->lang_key) ? $this->Lang->get($Menu->lang_key) : $Menu->name;

        if($post['selected'] == true)
        {
          $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.appAssignedJournal', array('app' => $appName, 'email' => $User->email))), $Journal);
        }
        else
        {
          $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.appUnassignedJournal', array('app' => $appName, 'email' => $User->email))), $Journal);
        }
      });

			if(!empty($post["permissionsModuleId"]))
			{
				$userMenus = $this->getUserMenusByModule($post["userId"], $post["permissionsModuleId"], $organizationId);
				$permissionModuleMenus = $this->getMenusByModule($post["permissionsModuleId"]);

				foreach ($permissionModuleMenus as $key => $menu)
				{
					if(!isset($userMenus[$menu['value']]))
					{
						unset($permissionModuleMenus[$key]);
					}
				}

				$permissionModuleMenus = array_merge(array(), $permissionModuleMenus);

				if(isset($permissionModuleMenus[0]['value']))
				{
					$menuPermissions = $this->getPermissionsByMenus($permissionModuleMenus[0]['value']);
					$userPermissions = $this->getUserPermissionByMenuAndByOrganization($post["userId"], $permissionModuleMenus[0]['value'], $organizationId);
				}
				else
				{
					$menuPermissions = $userPermissions = array();
				}
			}
		});

		return json_encode(array('permissionModuleMenus' => $permissionModuleMenus, 'menuPermissions' => $menuPermissions, 'userPermissions' => $userPermissions));
	}

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
	public function resetMenus(array $post)
	{
		$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

		$this->DB->transaction(function() use ($organizationId, $post, &$userMenus, &$userModuleMenus, &$permissionModuleMenus, &$menuPermissions, &$userPermissions)
		{
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();

      $User = $this->User->byId($post['userId']);
			$affectedRows = $this->User->detachAllMenus($post['userId'], $organizationId);

      if($affectedRows > 0)
      {
        $Journal = $this->Journal->create(array('journalized_id' => $post['userId'], 'journalized_type' => $this->User->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.appsResttedJournal', array('email' => $User->email))), $Journal);
      }

			if($post["menuOptionModuleId"] == $post["permissionsModuleId"])
			{
				$userMenus = $userMenusPermissionModule = $this->getUserMenusByModule($post["userId"], $post["menuOptionModuleId"], $organizationId);
				$userModuleMenus = $permissionModuleMenus = $this->getMenusByModule($post["menuOptionModuleId"]);
			}
			else
			{
				$userMenus = $this->getUserMenusByModule($post["userId"], $post["menuOptionModuleId"], $organizationId);
				$userMenusPermissionModule = $this->getUserMenusByModule($post["userId"], $post["permissionsModuleId"], $organizationId);
				$userModuleMenus = $this->getMenusByModule($post["menuOptionModuleId"]);
				$permissionModuleMenus = $this->getMenusByModule($post["permissionsModuleId"]);
			}

			foreach ($permissionModuleMenus as $key => $menu)
			{
				if(!isset($userMenusPermissionModule[$menu['value']]))
				{
					unset($permissionModuleMenus[$key]);
				}
			}

			$permissionModuleMenus = array_merge(array(), $permissionModuleMenus);

			if(isset($permissionModuleMenus[0]['value']))
			{
				$menuPermissions = $this->getPermissionsByMenus($permissionModuleMenus[0]['value']);
				$userPermissions = $this->getUserPermissionByMenuAndByOrganization($post["userId"], $permissionModuleMenus[0]['value'], $organizationId);
			}
			else
			{
				$menuPermissions = $userPermissions = array();
			}
		});

		return json_encode(array('userMenus' => $userMenus, 'userModuleMenus' => $userModuleMenus, 'permissionModuleMenus' => $permissionModuleMenus, 'menuPermissions' => $menuPermissions, 'userPermissions' => $userPermissions));
	}

	/**
	 * Save permissions menus.
	 *
	 * @param array $post
	 * 	An array as follows: array("permissionsId" => array($id0, $id1), "selected" => true|false, "userId"=>$userId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *    In case of success: {"success":form.defaultSuccessSaveMessage}
	 */
	public function savePermissions(array $post)
	{
		$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

		$this->DB->transaction(function() use ($organizationId, $post)
		{
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();

      $User = $this->User->byId($post['userId']);
      $this->User->attachPermissions($post['userId'], $post['permissionsId'], $post['selected'], $organizationId, $this->AuthenticationManager->getLoggedUserId(), $User);

      $Journal = $this->Journal->create(array('journalized_id' => $post['userId'], 'journalized_type' => $this->User->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));

      $this->Permission->permissionsById($post['permissionsId'])->each(function($Permission) use($Journal, $User, $post, $organizationId, $loggedUserId)
      {
        $permissionName = $this->Lang->has($Permission->lang_key) ? $this->Lang->get($Permission->lang_key) : $Permission->name;

				$this->Cache->forget('userAppPermissions' . $post['userId'] . $Permission->menu_id . $organizationId);

        if($post['selected'] == true)
        {
          $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.permissionAssignedJournal', array('permission' => $permissionName, 'email' => $User->email))), $Journal);
        }
        else
        {
          $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.permissionUnassignedJournal', array('permission' => $permissionName, 'email' => $User->email))), $Journal);
        }
      });

		});

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
	}

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
	public function getAccessControlList(array $post)
	{
		$userRoles = array();

		$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

		$this->User->rolesByUserAndByOrganization($post["userId"], $organizationId)->each(function($role) use (&$userRoles)
		{
			$userRoles = array_add($userRoles, $role->id, $role->name);
		});

		$organizationRoles = array();

		// $this->Organization->rolesByOrganization($organizationId)->each(function($role) use (&$organizationRoles)
		// {
		// 	array_push($organizationRoles, array('value'=>$role->id, 'text'=>($this->Lang->has($role->lang_key) ? $this->Lang->get($role->lang_key) : $role->name)));
		// });

		//roles() -> organizationId = null
		$this->Role->roles()->each(function($Role) use (&$organizationRoles)
		{
			array_push($organizationRoles, array('value'=>$Role->id, 'text'=>($this->Lang->has($Role->lang_key) ? $this->Lang->get($Role->lang_key) : $Role->name)));
		});

		if($post["menuOptionModuleId"] == $post["permissionsModuleId"])
		{
			$userMenus = $userMenusPermissionModule = $this->getUserMenusByModule($post["userId"], $post["menuOptionModuleId"], $organizationId);
			$userModuleMenus = $permissionModuleMenus = $this->getMenusByModule($post["menuOptionModuleId"]);
		}
		else
		{
			$userMenus = $this->getUserMenusByModule($post["userId"], $post["menuOptionModuleId"], $organizationId);
			$userMenusPermissionModule = $this->getUserMenusByModule($post["userId"], $post["permissionsModuleId"], $organizationId);
			$userModuleMenus = $this->getMenusByModule($post["menuOptionModuleId"]);
			$permissionModuleMenus = $this->getMenusByModule($post["permissionsModuleId"]);
		}

		foreach ($permissionModuleMenus as $key => $menu)
		{
			if(!isset($userMenusPermissionModule[$menu['value']]))
			{
				unset($permissionModuleMenus[$key]);
			}
		}

		$permissionModuleMenus = array_merge(array(), $permissionModuleMenus);

		if(isset($permissionModuleMenus[0]['value']))
		{
			$menuPermissions = $this->getPermissionsByMenus($permissionModuleMenus[0]['value']);
			$userPermissions = $this->getUserPermissionByMenuAndByOrganization($post["userId"], $permissionModuleMenus[0]['value'], $organizationId);
		}
		else
		{
			$menuPermissions = $userPermissions = array();
		}

		return json_encode(array('userRoles' => $userRoles, 'organizationRoles' => $organizationRoles, 'userMenus' => $userMenus, 'userModuleMenus' => $userModuleMenus, 'permissionModuleMenus' => $permissionModuleMenus, 'menuPermissions' => $menuPermissions, 'userPermissions' => $userPermissions));
	}

	/**
	 * Get user data by email.
	 *
	 * @param array $post
	 * 	An array as follows: array("email"=>$email);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  If user exist {question: security/user-management.questionToAssociateUser, userData: {id: $id, firstname: $firstname, lastname: $lastname}}
	 *  If user is already part of the current organization: {userAlreadyInOrganizationException: security/user-management.userAlreadyInOrganizationException}
	 *  If user does not exist {userData: false}
	 */
	public function getUserByEmail(array $post)
	{
		$User = $this->User->byEmail($post['email']);

		if($User->isEmpty())
		{
			return json_encode(array('userData' => false));
		}

		$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

		foreach ($this->getUserOrganizations($User[0]->id) as $key => $organization)
		{
			if($organization['id'] == $organizationId)
			{
				return json_encode(array('userAlreadyInOrganizationException' => $this->Lang->get('security/user-management.userAlreadyInOrganizationException', array('email' => $post['email'], 'organization' => $this->AuthenticationManager->getCurrentUserOrganization('name')))));
			}
		}

		return json_encode(array('question' => $this->Lang->get('security/user-management.questionToAssociateUser', array('email' => $post['email'], 'organization' => $this->AuthenticationManager->getCurrentUserOrganization('name'))), 'userData' => array('id' => $User[0]->id, 'firstname' => $User[0]->firstname, 'lastname' => $User[0]->lastname)));
	}

	/**
	 * Get user names by id.
	 *
	 * @param int $id
	 *
	 * @return string
	 */
	public function getUserNameById($id)
	{
		$User = $this->User->byId($id);

		if(empty($User))
		{
			return '';
		}

		return $User->firstname . ' ' . $User->lastname;
	}

	/**
	 * Get an specific column of a user by email.
	 *
	 * @param string $email
	 * @param string $email
	 *
	 * @return string
	 */
	public function getUserColumnByEmail($email, $columnName)
	{
		$User = $this->User->byEmail($email);

		if($User->isEmpty())
		{
			return '';
		}

		return $User[0]->$columnName;
	}

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
	public function getNonAdminUserByEmail(array $post)
	{
		$User = $this->User->byEmail($post['email']);

		if($User->isEmpty())
		{
			return json_encode(array('userData' => false));
		}

		if($User[0]->is_admin == '1')
		{
			return json_encode(array('userAlreadyAdminException' => $this->Lang->get('security/user-management.userAlreadyAdminException', array('email' => $post['email']))));
		}

		return json_encode(array('question' => $this->Lang->get('security/user-management.questionToSetUserAsAdmin', array('email' => $post['email'], 'organization' => $this->AuthenticationManager->getCurrentUserOrganization('name'))), 'userData' => array('id' => $User[0]->id, 'firstname' => $User[0]->firstname, 'lastname' => $User[0]->lastname)));
	}

	/**
	 * Get user and module menus
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
	public function getUserAndModuleMenus(array $post)
	{
		$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

		$userMenus = $this->getUserMenusByModule($post["userId"], $post["moduleId"], $organizationId);
		$userModuleMenus = $permissionModuleMenus = $this->getMenusByModule($post["moduleId"]);

		return json_encode(array('userMenus' => $userMenus, 'userModuleMenus' => $userModuleMenus));
	}

	/**
	 * Get user menus by module and menu permissions
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
	public function getUserMenusByModuleAndMenuPermissions(array $post)
	{
		$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
		$userMenus = $this->getUserMenusByModule($post["userId"], $post["moduleId"], $organizationId);
		$moduleMenus = $this->getMenusByModule($post["moduleId"]);

		foreach ($moduleMenus as $key => $menu)
		{
			if(!isset($userMenus[$menu['value']]))
			{
				unset($moduleMenus[$key]);
			}
		}

		$moduleMenus = array_merge(array(), $moduleMenus);

		if(isset($moduleMenus[0]['value']))
		{
			$menuPermissions = $this->getPermissionsByMenus($moduleMenus[0]['value']);
			$userPermissions = $this->getUserPermissionByMenuAndByOrganization($post["userId"], $moduleMenus[0]['value'], $organizationId);
		}
		else
		{
			$menuPermissions = $userPermissions = array();
		}

		return json_encode(array('permissionModuleMenus' => $moduleMenus, 'menuPermissions' => $menuPermissions, 'userPermissions' => $userPermissions));
	}

	/**
	 * Get user menus permissions by menu
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
	public function getUserPermissionsByMenu(array $post)
	{
		$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

		$menuPermissions = $this->getPermissionsByMenus($post["menuId"]);
		$userPermissions = $this->getUserPermissionByMenuAndByOrganization($post["userId"], $post["menuId"], $organizationId);

		return json_encode(array('menuPermissions' => $menuPermissions, 'userPermissions' => $userPermissions));
	}

	/**
	 * Get system modules
	 *
	 * @return array
	 *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
	 */
	public function getSystemModules()
	{
		$modules = array();

		$this->Module->all()->each(function($Module) use (&$modules)
		{
			array_push($modules, array('label'=>($this->Lang->has($Module->lang_key) ? $this->Lang->get($Module->lang_key) : $Module->name), 'value'=>$Module->id));
		});

		return $modules;
	}

	/**
	 * Get timezones
	 *
	 * @return array
	 *  An array of arrays as follows: array($timezone1, $timezone2,…)
	 */
	public function getTimezones()
	{
		return $this->DateTimeZone->listIdentifiers(DateTimeZone::ALL);
	}

	/**
	 * Get User Preferences Page Journals
	 *
	 * @return
	 */
	public function getUserChangesJournals($id = null)
	{
		if(empty($id))
		{
			$id = $this->AuthenticationManager->getLoggedUserId();
		}

		return $this->JournalManager->getJournalsByApp(array('appId' => 'user-preferences-changes', 'page' => 1, 'journalizedId' => $id, 'filter' => null, 'userId' => null, 'onlyActions' => false), true);
	}

  /**
   * Get User Preferences Page Journals
   *
   * @return
   */
  public function getUserActionsJournals($id = null)
  {
    if(empty($id))
    {
      $id = $this->AuthenticationManager->getLoggedUserId();
    }

    return $this->JournalManager->getJournalsByApp(array('appId' => 'user-preferences-actions', 'page' => 1, 'journalizedId' => null, 'filter' => null, 'userId' => $id, 'onlyActions' => true), true);
  }

	/**
	 * Echo user grid data in a jqGrid compatible format
	 *
	 * @param array $post
	 *	All jqGrid posted data
	 *
	 * @return void
	 */
	public function getUserGridData(array $post)
	{
		$this->GridEncoder->encodeRequestedData($this->EloquentUserGridRepository, $post);
	}

	/**
	 * Echo admin user grid data in a jqGrid compatible format
	 *
	 * @param array $post
	 *	All jqGrid posted data
	 *
	 * @return void
	 */
	public function getAdminUserGridData(array $post)
	{
		$this->GridEncoder->encodeRequestedData($this->EloquentAdminUserGridRepository, $post);
	}

	/**
	 * Get the number of organizations to which the user is associated
	 *
	 * @param  int $id User id
	 *
	 * @return integer
	 */
	public function getCountUserOrganizations($id = null)
	{
		if(empty($id))
		{
			$id = $this->AuthenticationManager->getLoggedUserId();
		}

		if($this->Cache->has('userOrganizationCount' . $id))
		{
			return (int) $this->Cache->get('userOrganizationCount' . $id);
		}

		if($this->AuthenticationManager->isUserRoot($id))
		{
			$count = $this->Organization->all()->count();
		}
		else
		{
			$count = $this->User->organizationByUser($id)->count();
		}

		$this->Cache->put('userOrganizationCount'  . $id, $count, 360);

		return $count;
	}

	/**
	 * Get fisrt organization to which the user is associated
	 *
	 * @param  int $id User id
	 *
	 * @return array
	 */
	public function getFirstUserOrganizations($id = null, $organizationsExcludedIds)
	{
		if(empty($id))
		{
			$id = $this->AuthenticationManager->getLoggedUserId();
		}

		return $this->User->organizationByUserWithExceptions($id, $organizationsExcludedIds)->first()->toArray();
	}

	/**
	 * Get organizations to which the user is associated
	 *
	 * @param  int $id User id
	 *
	 * @return array
	 */
	public function getUserOrganizations($id = null)
	{
		if(empty($id))
		{
			$id = $this->AuthenticationManager->getLoggedUserId();
		}

		if($id == -1)
		{
			return array();
		}

		if($this->AuthenticationManager->isUserRoot($id))
		{
			if($this->Cache->has('allOrganization'))
			{
				$organizations = json_decode($this->Cache->get('allOrganization'), true);
			}
			else
			{
				$organizations = $this->Organization->all()->toArray();
				$this->Cache->put('allOrganization', json_encode($organizations), 360);
			}

			// return $this->Organization->all()->toArray();
		}
		else
		{
			if($this->Cache->has('userOrganizations' . $id))
			{
				$organizations = json_decode($this->Cache->get('userOrganizations' . $id), true);
			}
			else
			{
				$organizations = $this->User->organizationByUser($id)->toArray();
				$this->Cache->put('userOrganizations' . $id, json_encode($organizations), 360);
			}

			// return $this->User->organizationByUser($id)->toArray();
		}

		return $organizations;
	}

	/**
	* Get organizations to which the user is associated (autocomplete)
	*
	* @return array
	*  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
	*/
	public function getUserOrganizationsAutocomplete($id = null)
	{
		if(empty($id))
		{
			$id = $this->AuthenticationManager->getLoggedUserId();
		}

		$organizationsAutocomplete = array();

		if($this->AuthenticationManager->isUserRoot($id))
		{
			if($this->Cache->has('allOrganization'))
			{
				$organizations = json_decode($this->Cache->get('allOrganization'), true);
			}
			else
			{
				$organizations = $this->Organization->all()->toArray();
				$this->Cache->put('allOrganization', json_encode($organizations), 360);
			}

			// $this->Organization->all()->each(function($Organization) use (&$organizations)
			// {
			// 	array_push($organizations, array('label' => $Organization->name, 'value' => $Organization->id));
			// });
		}
		else
		{
			if($this->Cache->has('userOrganizations' . $id))
			{
				$organizations = json_decode($this->Cache->get('userOrganizations' . $id), true);
			}
			else
			{
				$organizations = $this->User->organizationByUser($id)->toArray();
				$this->Cache->put('userOrganizations' . $id, json_encode($organizations), 360);
			}

			// $this->User->organizationByUser($id)->each(function($Organization) use (&$organizations)
			// {
			// 	array_push($organizations, array('label' => $Organization->name, 'value' => $Organization->id));
			// });
		}

		foreach ($organizations as $key => $organization)
		{
			array_push($organizationsAutocomplete, array('label' => $organization['name'], 'value' => $organization['id']));
		}

		return $organizationsAutocomplete;
	}

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
	public function getUserActions($userId = null, $organizationId = null)
	{
		if(empty($organizationId))
		{
			$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
			$organizationOwner = $this->AuthenticationManager->getCurrentUserOrganization('created_by');
		}

		if(empty($userId))
		{
			if($this->AuthenticationManager->isUserRoot() && !empty($organizationOwner))
			{
				$userId = $organizationOwner;
			}
			else
			{
				$userId = $this->AuthenticationManager->getLoggedUserId();
			}
		}

		if($this->Cache->has('userActions' . $userId . $organizationId))
		{
			return json_decode($this->Cache->get('userActions' . $userId . $organizationId), true);
		}

		$userActions = array();

		$this->User->modulesByUser($userId, $organizationId)->each(function($module)  use (&$userActions, $userId, $organizationId)
		{
			$this->User->menusByUserRolesByModuleAndByOrganization($userId, $module->id, $organizationId)->each(function($menu)  use (&$userActions, &$parentsMenus, $userId, $organizationId)
			{
				$userPermissionsId = $this->getUserPermissionsShorcutsIdByMenuAndByOrganization($userId, $menu->id, $organizationId);

				$this->Menu->permissionsByMenu($menu->id)->each(function($permission) use (&$userActions, $menu, $userPermissionsId)
				{
					if($permission->is_only_shortcut || in_array($permission->id, $userPermissionsId))
					{
						$userActions = array_add($userActions, 1000 + $permission->id, array('label' => $this->Lang->get($permission->action_lang_key), 'actionButtonId' => '', 'value' => ($this->Lang->has($permission->lang_key) ? $this->Lang->get($permission->lang_key) : $permission->name)));
					}
				});

				$userActions = array_add($userActions, $menu->id, array('label' => $this->Lang->get($menu->action_lang_key), 'actionButtonId' => '', 'value' => ($this->Lang->has($menu->lang_key) ? $this->Lang->get($menu->lang_key) : $menu->name)));
			});

			$this->User->menusByUserByModuleAndByOrganization($userId, $module->id, $organizationId)->each(function($menu) use (&$userActions, $userId, $organizationId)
			{
				if(!$menu->pivot->is_assigned && isset($userActions[$menu->id]))
				{
					unset($userActions[$menu->id]);
				}

				if($menu->pivot->is_assigned)
				{
					$userPermissionsId = $this->getUserPermissionsShorcutsIdByMenuAndByOrganization($userId, $menu->id, $organizationId);

					$this->Menu->permissionsByMenu($menu->id)->each(function($permission) use (&$userActions, $menu, $userPermissionsId)
					{
						if($permission->is_only_shortcut || in_array($permission->id, $userPermissionsId))
						{
							$userActions = array_add($userActions, 1000 + $permission->id, array('label' => $this->Lang->get($permission->action_lang_key), 'actionButtonId' => '', 'value' => ($this->Lang->has($permission->lang_key) ? $this->Lang->get($permission->lang_key) : $permission->name)));
						}
					});

					$userActions = array_add($userActions, $menu->id, array('label' => $this->Lang->get($menu->action_lang_key), 'actionButtonId' => '', 'value' =>($this->Lang->has($menu->lang_key) ? $this->Lang->get($menu->lang_key) : $menu->name)));
				}
			});
		});

		foreach ($this->Config->get('public-shortcut') as $key => $shortcut)
		{
			$userActions = array_add($userActions, $key, array('label' => $this->Lang->get($shortcut['langKey']), 'actionButtonId' => $shortcut['actionButtonId'], 'value' => $key));
		}

		$userActions = array_values($userActions);

		$this->Cache->put('userActions' . $userId . $organizationId, json_encode($userActions), 360);

		return $userActions;
	}

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
	public function getUserAppPermissions($userId = null, $menuId = null, $organizationId = null, $url = null)
	{
		if(empty($organizationId))
		{
			$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
			$organizationOwner = $this->AuthenticationManager->getCurrentUserOrganization('created_by');
		}

		if(empty($userId))
		{
			if($this->AuthenticationManager->isUserRoot() && !empty($organizationOwner))
			{
				$userId = $organizationOwner;
			}
			else
			{
				$userId = $this->AuthenticationManager->getLoggedUserId();
			}
		}

		if(empty($menuId))
		{
			if(empty($url))
			{
				$url = str_replace($this->Url->to('/'), '', $this->Url->current());
			}

			if($this->Cache->has($url))
			{
				$menu = json_decode($this->Cache->get($url), true);
			}
			else
			{
				$Menu = $this->Menu->menuByUrl($url);

				if($Menu->count() == 0)
				{
					return array();
				}

				$menu = $Menu[0]->toArray();
				$this->Cache->put($url, json_encode($menu), 360);
			}

			$menuId = $menu['id'];

			// $Menu = $this->Menu->menuByUrl($url);
      //
			// if($Menu->isEmpty())
			// {
			// 	return array();
			// }
      //
			// $menuId = $Menu[0]->id;
		}

		if($this->Cache->has('userAppPermissions' . $userId . $menuId . $organizationId))
		{
			return json_decode($this->Cache->get('userAppPermissions' . $userId . $menuId . $organizationId), true);
		}

		$userAppPermissions = array();

		$this->User->permissionsByUserRolesByMenuAndByOrganization($userId, $menuId, $organizationId)->each(function($permission) use (&$userAppPermissions)
		{
			$userAppPermissions = array_add($userAppPermissions, $permission->key, $permission->name);
		});

		$this->User->permissionsByUserByMenuAndByOrganization($userId, $menuId, $organizationId)->each(function($permission) use (&$userAppPermissions)
		{
			if(!$permission->pivot->is_assigned && isset($userAppPermissions[$permission->key]))
			{
				unset($userAppPermissions[$permission->key]);
			}

			if($permission->pivot->is_assigned)
			{
				$userAppPermissions = array_add($userAppPermissions, $permission->key, $permission->name);
			}
		});

		$this->Cache->put('userAppPermissions' . $userId . $menuId . $organizationId, json_encode($userAppPermissions), 360);

		return $userAppPermissions;
	}

	/**
	 * Change logged user organization
	 *
	 * @return void
	 */
	public function changeLoggedUserOrganization(array $input)
	{
		$Organization = $this->Organization->byId($input['id']);

		// $this->Event->fire(new OnNewInfoMessage(array('message' => '[SECURITY EVENT] User has changed his current organization', 'context' => array('organizationName' => $Organization->name)), $this->AuthenticationManager));

		$this->Log->info('[SECURITY EVENT] User has changed his current organization', array('organizationName' => $Organization->name));

		$this->AuthenticationManager->setCurrentUserOrganization($Organization);
	}

	/**
	 * Get user menu
	 *
	 * @param array $post
	 * 	An array as follows: array("id"=>$userId);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  [ { name: $moduleName, icon: $icon, childsMenus: [ { name: $menuName, url: $url, aliasUrl: $aliasUrl, actionButtonId: $actionButtonId, icon: $icon, hidden: $hidden, childsMenus: [ { … },… ] },… ] },…]
	 *
	 */
	public function getUserMenu(array $post)
	{
		return $this->buildUserMenu($post['id']);
	}

	/**
	 * Build user menu
	 *
	 * @param  int $userId
	 * @param  int $organizationId
	 * @param  boolean $returnArray
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  [ { name: $moduleName, icon: $icon, childsMenus: [ { name: $menuName, url: $url, aliasUrl: $aliasUrl, actionButtonId: $actionButtonId, icon: $icon, hidden: $hidden, childsMenus: [ { … },… ] },… ] },…]
	 *
	 */
	public function buildUserMenu($userId = null, $organizationId = null, $returnArray = false)
	{
		if(empty($organizationId))
		{
			$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
			$organizationOwner = $this->AuthenticationManager->getCurrentUserOrganization('created_by');
		}

		if(empty($userId) && $this->AuthenticationManager->isUserGuest())
		{
			return json_encode(array());
		}
		else if(empty($userId))
		{
			if($this->AuthenticationManager->isUserRoot() && !empty($organizationOwner))
			{
				$userId = $organizationOwner;
			}
			else
			{
				$userId = $this->AuthenticationManager->getLoggedUserId();
			}
		}

		if($this->Cache->has('userApps' . $userId . $organizationId))
		{
			$userApps = json_decode($this->Cache->get('userApps' . $userId . $organizationId), true);

			if($returnArray)
			{
				return $userApps;
			}

			return json_encode($userApps);
		}

		$userApps = array();

		$this->User->modulesByUser($userId, $organizationId)->each(function($module)  use (&$userApps, $userId, $organizationId)
		{
			$userMenus = $parentsMenus = $moduleChildMenus = array();

			$this->User->menusByUserRolesByModuleAndByOrganization($userId, $module->id, $organizationId)->each(function($menu)  use (&$userMenus, &$parentsMenus, $userId, $organizationId)
			{
				$userPermissionsId = $this->getUserPermissionsShorcutsIdByMenuAndByOrganization($userId, $menu->id, $organizationId);

				$this->Menu->permissionsByMenu($menu->id)->each(function($permission) use (&$userMenus, $menu, $userPermissionsId)
				{
					if($permission->is_only_shortcut || in_array($permission->id, $userPermissionsId))
					{
						$userMenus = array_add($userMenus, 1000 + $permission->id, array('id' => $permission->id, 'parentId' => $menu->parent_id, 'hidden' => $permission->hidden, 'childsMenus' => array(), 'icon' => $permission->icon, 'url' => $permission->url, 'aliasUrl' => $permission->alias_url, 'actionButtonId' => $permission->action_button_id, 'name' => ($this->Lang->has($permission->lang_key) ? $this->Lang->get($permission->lang_key) : $permission->name)));
					}
				});

				$userMenus = array_add($userMenus, $menu->id, array('id'=>$menu->id, 'parentId' => $menu->parent_id, 'hidden' => false, 'childsMenus' => array(), 'icon' => $menu->icon, 'url' => $menu->url, 'aliasUrl' => '', 'actionButtonId' => $menu->action_button_id, 'name'=>($this->Lang->has($menu->lang_key) ? $this->Lang->get($menu->lang_key) : $menu->name)));
			});

			$this->User->menusByUserByModuleAndByOrganization($userId, $module->id, $organizationId)->each(function($menu) use (&$userMenus, $userId, $organizationId)
			{
				if(!$menu->pivot->is_assigned && isset($userMenus[$menu->id]))
				{
					unset($userMenus[$menu->id]);
				}

				if($menu->pivot->is_assigned)
				{
					$userPermissionsId = $this->getUserPermissionsShorcutsIdByMenuAndByOrganization($userId, $menu->id, $organizationId);

					$this->Menu->permissionsByMenu($menu->id)->each(function($permission) use (&$userMenus, $menu, $userPermissionsId)
					{
						if($permission->is_only_shortcut || in_array($permission->id, $userPermissionsId))
						{
							$userMenus = array_add($userMenus, 1000 + $permission->id, array('id'=>$permission->id, 'parentId' => $menu->parent_id, 'hidden' => $permission->hidden, 'childsMenus' => array(), 'icon' => $permission->icon, 'url' => $permission->url, 'aliasUrl' => $permission->alias_url, 'actionButtonId' => $permission->action_button_id, 'name'=>($this->Lang->has($permission->lang_key) ? $this->Lang->get($permission->lang_key) : $permission->name)));
						}
					});

					$userMenus = array_add($userMenus, $menu->id, array('id'=>$menu->id, 'parentId' => $menu->parent_id, 'hidden' => false, 'childsMenus' => array(), 'icon' => $menu->icon, 'url' => $menu->url, 'aliasUrl' => '', 'actionButtonId' => $menu->action_button_id, 'name'=>($this->Lang->has($menu->lang_key) ? $this->Lang->get($menu->lang_key) : $menu->name)));
				}
			});

			$this->Menu->parentMenusByModule( $module->id )->each(function($menu) use (&$parentsMenus, &$userMenus)
			{
				if(empty($menu->parent_id))
				{
					$parentsMenus = array_add($parentsMenus, $menu->id, array('id'=>$menu->id, 'parentId' => $menu->parent_id, 'hidden' => false, 'childsMenus' => array(), 'icon' => $menu->icon, 'url' => $menu->url, 'name'=>($this->Lang->has($menu->lang_key) ? $this->Lang->get($menu->lang_key) : $menu->name)));
				}
				else
				{
					$userMenus = array_add($userMenus, $menu->id, array('id'=>$menu->id, 'parentId' => $menu->parent_id, 'hidden' => false, 'childsMenus' => array(), 'icon' => $menu->icon, 'url' => $menu->url, 'name'=>($this->Lang->has($menu->lang_key) ? $this->Lang->get($menu->lang_key) : $menu->name)));
				}
			});

			foreach ($parentsMenus as $menuId => $menu)
			{
				if($this->hasChild($menuId, $userMenus))
				{
					unset($menu['id']);
					unset($menu['parentId']);

					$this->populateChilds($menu['childsMenus'], $menuId, $userMenus);

					array_push($moduleChildMenus, $menu);
				}
			}

			foreach ($userMenus as $id => $menu)
			{
				if(empty($menu['parentId']) && !empty($menu['url']))
				{
					unset($menu['id']);
					unset($menu['parentId']);
					array_push($moduleChildMenus, $menu);
				}
			}

			if(!empty($moduleChildMenus))
			{
				array_push($userApps, array('name' => $this->Lang->get($module->lang_key), 'icon' => $module->icon, 'childsMenus' => $moduleChildMenus));
			}
		});

		$userAppsJsonEncoded = json_encode($userApps);

		$this->Cache->put('userApps' . $userId . $organizationId, $userAppsJsonEncoded, 360);

		if($returnArray)
		{
			return $userApps;
		}

		return $userAppsJsonEncoded;
	}

	/**
	 * Finds out if a parent menu has child menus.
	 *
	 * @param  int $menuId
	 * @param  array $childsMenus
	 *
	 * @return true if has at least one child, false otherwise
	 */
	public function hasChild($menuId, $childsMenu)
	{
		$childsMenuCopy = $childsMenu;

		foreach ($childsMenu as $id => $menu)
		{
			if($menu['parentId'] == $menuId)
			{
				if(!empty($menu['url']))
				{
					return true;
				}
				else
				{
					if($this->hasChild($id, $childsMenuCopy))
					{
						return true;
					}
				}
			}
		}

		return false;
	}


	/**
	 * Populate a parent menu with its menu childs.
	 *
	 * @param  array &$parentMenuChildsArray
	 * @param	int $parentMenuId
	 * @param  array $childsMenu
	 *
	 * @return array
	 */
	public function populateChilds(&$parentMenuChildsArray, $parentMenuId, $childsMenu)
	{
		$childsMenuCopy = $childsMenu;

		foreach ($childsMenu as $id => $menu)
		{
			if($menu['parentId'] == $parentMenuId)
			{
				if(!empty($menu['url']))
				{
					unset($menu['id']);
					unset($menu['parentId']);

					array_push($parentMenuChildsArray, $menu);
				}
				else
				{
					if($this->hasChild($id, $childsMenuCopy))
					{
						unset($menu['id']);
						unset($menu['parentId']);

						$this->populateChilds($menu['childsMenus'], $id, $childsMenuCopy);

						array_push($parentMenuChildsArray, $menu);
					}
				}
			}
		}
	}


	/**
	 * Get all menus assigned to a user by module in an organization.
	 *
	 * @param  int $userId
     * @param  int $moduleId
     * @param  int $organizationId
	 *
	 * @return array
	 */
	public function getUserMenusByModule($userId, $moduleId, $organizationId)
	{
		$userMenus = array();

		$this->User->menusByUserRolesByModuleAndByOrganization($userId, $moduleId, $organizationId)->each(function($menu)  use (&$userMenus)
		{
			$userMenus = array_add($userMenus, $menu->id, $menu->name);
		});


		$this->User->menusByUserByModuleAndByOrganization($userId, $moduleId, $organizationId)->each(function($menu) use (&$userMenus)
		{
			if(!$menu->pivot->is_assigned && isset($userMenus[$menu->id]))
			{
				unset($userMenus[$menu->id]);
			}

			if($menu->pivot->is_assigned && !in_array($menu->id, $this->Config->get('system-security.admin_apps_id')))
			{
				$userMenus = array_add($userMenus, $menu->id, $menu->name);
			}
		});

		return $userMenus;
	}

	/**
	 * Get all menus belonging to a module.
	 *
	 * @param  int $moduleId
	 *
	 * @return array
	 */
	public function getMenusByModule($moduleId)
	{
		$moduleMenus = array();

		$this->Module->menusByModule($moduleId)->each(function($menu) use (&$moduleMenus)
		{
			if(!empty($menu->url) && !in_array($menu->id, $this->Config->get('system-security.admin_apps_id')))
			{
				array_push($moduleMenus, array('value'=>$menu->id, 'text'=>($this->Lang->has($menu->lang_key) ? $this->Lang->get($menu->lang_key) : $menu->name) , 'label'=>($this->Lang->has($menu->lang_key) ? $this->Lang->get($menu->lang_key) : $menu->name)));
			}
		});

		return $moduleMenus;
	}

	/**
	 * Get all permissions assigned to a user by menu in an organization.
	 *
	 * @param  int $userId
	 * @param  int $menuId
	 * @param  int $organizationId
	 *
	 * @return array
	 */
	public function getUserPermissionByMenuAndByOrganization($userId, $menuId, $organizationId)
	{
		$userPermissions = array();

		$this->User->permissionsByUserRolesByMenuAndByOrganization($userId, $menuId, $organizationId)->each(function($permission) use (&$userPermissions)
		{
			$userPermissions = array_add($userPermissions, $permission->id, $permission->name);
		});

		$this->User->permissionsByUserByMenuAndByOrganization($userId, $menuId, $organizationId)->each(function($permission) use (&$userPermissions)
		{
			if(!$permission->pivot->is_assigned && isset($userPermissions[$permission->id]))
			{
				unset($userPermissions[$permission->id]);
			}

			if($permission->pivot->is_assigned && !in_array($permission->id, $this->Config->get('system-security.admin_permissions_id')))
			{
				$userPermissions = array_add($userPermissions, $permission->id, $permission->name);
			}
		});

		return $userPermissions;
	}

	/**
	 * Get all permissions shorcuts ID assigned to a user by menu in an organization.
	 *
	 * @param  int $userId
	 * @param  int $menuId
	 * @param  int $organizationId
	 *
	 * @return array
	 */
	public function getUserPermissionsShorcutsIdByMenuAndByOrganization($userId, $menuId, $organizationId)
	{
		$permissionsId = array();

		$this->User->permissionsByUserRolesByMenuAndByOrganization($userId, $menuId, $organizationId)->each(function($permission) use (&$permissionsId)
		{
			if(!empty($permission->url))
			{
				$permissionsId = array_add($permissionsId, $permission->id, $permission->name);
			}
		});

		$this->User->permissionsByUserByMenuAndByOrganization($userId, $menuId, $organizationId)->each(function($permission) use (&$permissionsId)
		{
			if(!empty($permission->url))
			{
				if(!$permission->pivot->is_assigned && isset($permissionsId[$permission->id]))
				{
					unset($permissionsId[$permission->id]);
				}

				if($permission->pivot->is_assigned)
				{
					$permissionsId = array_add($permissionsId, $permission->id, $permission->name);
				}
			}

		});

		return array_keys($permissionsId);
	}

	/**
	 * Get all permissions belonging to a menu.
	 *
	 * @param  int $menuId
	 *
	 * @return array
	 */
	public function getPermissionsByMenus($menuId)
	{
		$menuPermissions = array();

		$this->Menu->permissionsByMenu($menuId)->each(function($permission) use (&$menuPermissions)
		{
			// var_dump($permission->toArray());
			if(!$permission->is_only_shortcut && !in_array($permission->id, $this->Config->get('system-security.admin_permissions_id')))
			{
				array_push($menuPermissions, array('value'=>$permission->id, 'text'=>($this->Lang->has($permission->lang_key) ? $this->Lang->get($permission->lang_key) : $permission->name)));
			}
		});

		return $menuPermissions;
	}

}

<?php
/**
 * @file
 * Organization Manager Service.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Organization\Services\OrganizationManagement;

use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface;

use App\Kwaai\Security\Services\UserManagement\UserManagementInterface;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Kwaai\Organization\Repositories\Organization\OrganizationInterface;

use App\Kwaai\System\Repositories\Country\CountryInterface;

use App\Kwaai\System\Repositories\Currency\CurrencyInterface;

use App\Kwaai\Organization\Repositories\Organization\EloquentOrganizationGridRepository;

use Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface;

use App\Kwaai\Security\Services\AppManagement\AppManagementInterface;

use App\Kwaai\Security\Repositories\User\UserInterface;

use App\Kwaai\Security\Repositories\Journal\JournalInterface;

use App\Kwaai\Security\Repositories\Module\ModuleInterface;

use App\Kwaai\Security\Repositories\Menu\MenuInterface;

use App\Kwaai\Security\Repositories\Role\RoleInterface;

use App\Events\OnNewInfoMessage;

use App\Events\OnNewWarningMessage;

use Illuminate\Auth\AuthManager;

use Illuminate\Events\Dispatcher;

use Illuminate\Log\Writer;

use Illuminate\Database\DatabaseManager;

use Illuminate\Routing\UrlGenerator;

use Symfony\Component\Translation\TranslatorInterface;

class OrganizationManager implements OrganizationManagementInterface {

	/**
	 * Authentication Management Interface
	 *
	 * @var App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface
	 *
	 */
	protected $AuthenticationManager;

	/**
	 * User Management Interface
	 *
	 * @var App\Kwaai\Security\Services\UserManagement\UserManagementInterface
	 *
	 */
	protected $UserManager;

	/**
	 * Journal Management Interface
	 *
	 * @var App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface
	 *
	 */
	protected $JournalManager;

	/**
	 * Grid Encoder
	 *
	 * @var Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface
	 *
	 */
	protected $GridEncoder;

	/**
	 * Organization User Repository
	 *
	 * @var App\Kwaai\Organization\Repositories\Organization\EloquentOrganizationGridRepository
	 *
	 */
	protected $EloquentOrganizationGridRepository;

	/**
	 * Country
	 *
	 * @var App\Kwaai\System\Repositories\Country\CountryInterface
	 *
	 */
	protected $Country;

	/**
	* Currency Interface
	*
	* @var App\Kwaai\System\Repositories\Currency\CurrencyInterface
	*
	*/
	protected $Currency;

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
	 * User
	 *
	 * @var App\Kwaai\Security\Repositories\Role\RoleInterface
	 *
	 */
	protected $Role;

	/**
	* New Organization Trigger Interface Array
	*
	* @var App\Kwaai\Organization\Repositories\Organization\NewOrganizationTriggerInterface;
	*
	*/
	protected $newOrganizationTrigger;

	/**
	 * Laravel Database Manager
	 *
	 * @var Illuminate\Database\DatabaseManager
	 *
	 */
	protected $DB;

	/**
	 * Laravel Translator instance
	 *
	 * @var \Symfony\Component\Translation\TranslatorInterface
	 *
	 */
	protected $Lang;

	/**
	 * Laravel Writer (Log)
	 *
	 * @var Illuminate\Log\Writer
	 *
	 */
	protected $Log;

	/**
	 * Laravel Dispatcher instance
	 *
	 * @var \Illuminate\Events\Dispatcher
	 *
	 */
	protected $Event;

	public function __construct(AuthenticationManagementInterface $AuthenticationManager, UserManagementInterface $UserManager, JournalManagementInterface $JournalManager, RequestedDataInterface $GridEncoder, EloquentOrganizationGridRepository $EloquentOrganizationGridRepository, CountryInterface $Country, CurrencyInterface $Currency, OrganizationInterface $Organization, UserInterface $User, RoleInterface $Role, JournalInterface $Journal, array $newOrganizationTrigger, DatabaseManager $DB, TranslatorInterface $Lang, Writer $Log, Dispatcher $Event)
	{
		$this->AuthenticationManager = $AuthenticationManager;

		$this->UserManager = $UserManager;

		$this->JournalManager = $JournalManager;

		$this->GridEncoder = $GridEncoder;

		$this->EloquentOrganizationGridRepository = $EloquentOrganizationGridRepository;

		$this->Country = $Country;

		$this->Currency = $Currency;

		$this->Organization = $Organization;

		$this->User = $User;

		$this->Role = $Role;

		$this->Journal = $Journal;

		$this->newOrganizationTrigger = $newOrganizationTrigger;

		$this->DB = $DB;

		$this->Lang = $Lang;

		$this->Log = $Log;

		$this->Event = $Event;
	}

	/**
	 * Echo organization grid data in a jqGrid compatible format
	 *
	 * @param array $post
	 *	All jqGrid posted data
	 *
	 * @return void
	 */
	public function getOrganizationGridData(array $post)
	{
		$this->GridEncoder->encodeRequestedData($this->EloquentOrganizationGridRepository, $post);
	}

	/**
	 * Get system countries
	 *
	 * @return array
	 *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
	 */
	public function getSystemCountries()
	{
		$countries = array();

		$this->Country->all()->each(function($Country) use (&$countries)
		{
			array_push($countries, array('label'=> $Country->name, 'value'=>$Country->id));
		});

		return $countries;
	}

	/**
	* Get system currencies
	*
	* @return array
	*  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
	*/
	public function getSystemCurrencies()
	{
		$currencies = array();

		$this->Currency->all()->each(function($Currency) use (&$currencies)
		{
			array_push($currencies, array('label'=> $Currency->name . ' (' . $Currency->symbol . ')', 'value'=>$Currency->id));
		});

		return $currencies;
	}

	/**
	* Get Dashboard Page Journals
	*
	* @return array
	*/
	public function getOrganizationJournals()
	{
		return $this->JournalManager->getJournalsByApp(array('appId' => 'dashboard', 'page' => 1, 'journalizedId' => null, 'filter' => null, 'userId' => null, 'onlyActions' => true), true);
	}

	/**
	* Get organization by id
	*
	* @return App\Kwaai\Organization\Organization
	*/
	public function getOrganizationById($id)
	{
		return $this->Organization->byId($id);
	}

	/**
	* Get organization column by id
	*
	* @return App\Kwaai\Organization\Organization
	*/
	public function getOrganizationColumnById($id, $column = 'name')
	{
		$Organization = $this->Organization->byId($id);

		return $Organization->$column;
	}

	/**
	* Get organization currency symbol
	*
	* @return App\Kwaai\Organization\Organization
	*/
	public function getOrganizationCurrencySymbol($id = null)
	{
		if(empty($id))
		{
			$currencyId = $this->AuthenticationManager->getCurrentUserOrganizationCurrency();
		}
		else
		{
			$Organization = $this->Organization->byId($id);
			$currencyId = $Organization->currency_id;
		}

		if(empty($currencyId))
		{
			return '';
		}

		$Currency = $this->Currency->byId($currencyId);

		return $Currency->symbol;
	}

	/**
	* Get users by organization (autocomplete)
	*
	* @return array
	*  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
	*/
	public function getUsersByOrganization($id = null)
	{
		if(empty($id))
		{
			$id = $this->AuthenticationManager->getCurrentUserOrganizationId();
		}

		$users = array();

		$this->Organization->usersByOrganization($id)->each(function($User) use (&$users)
		{
			array_push($users, array('label' => $User->firstname . ' ' . $User->lastname, 'value' => $User->id));
		});

		return $users;
	}

	/**
	 * If user access this application for the first time, a welcome message should be shown.
	 *
	 * @return boolean
	 */
	public function showWelcomeMessage()
	{
		if($this->AuthenticationManager->isUserAdmin() && $this->UserManager->getCountUserOrganizations() == 0)
		{
			return true;
		}

		return false;
	}

	/**
	 * If user is not root the "created by" column must be hidden.
	 *
	 * @return boolean
	 *	True if is user is not root, false otherwise
	 */
	public function hideCreatedByColumn()
	{
		if($this->AuthenticationManager->isUserRoot())
		{
			return false;
		}

		return true;
	}

	/**
	 * If user is administrator and does not have at least one organization associated, the form to create an organization must be shown.
	 *
	 * @return string
	 */
	public function requestUserToCreateOrganization()
	{
		if($this->AuthenticationManager->isUserAdmin() && $this->UserManager->getCountUserOrganizations() == 0)
		{
			return true;
		}

		return false;
	}

	/**
	 * Create a new organization
	 *
	 * @param array $input
     * 	An array as follows: array('name'=>$name, 'street1'=>$street1, 'street2'=>$street2, 'zip_code'=>$zip_code, 'web_site'=>$web_site,
     * 							   'phone_number'=>$phone_number, 'fax'=>$fax, 'email'=>$email, 'tax_id'=>$tax_id, 'company_registration'=>$company_registration,
     * 							   'database_connection_name'=>$database_connection_name, 'country_id'=>$country_id, 'city_name'=>$city_name, 'state_name'=>$state_name
     * 						 );
     *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success and user has one organization: {"success" : form.defaultSuccessSaveMessage, "organizationName": $organizationName, "userApps" : [ { name: $moduleName, icon: $icon, childsMenus: [ { name: $menuName, url: $url, icon: $icon, childsMenus: [ { … },… ] },… ] },…], userActions: [{label: $action, value:$appMenuLabel}, {label: $action, value:$appMenuLabel},…]}
	 *	In case of success and user has two organization: {"success" : form.defaultSuccessSaveMessage, "organizationMenuTooltip" : 1, "currentUserOrganization" => $currentUserOrganization, "userOrganizations" : [{id: $organizationId0, name:$organizationName0}, {id: $organizationId1, name:$organizationName1}], organizationMenuLang: Lang::get('top-bar.userOrganizations')}
	 *  In case of success and user has three or more organization: {"success" : form.defaultSuccessSaveMessage, "currentUserOrganization" => $currentUserOrganization, "userOrganizations" : [{id: $organizationId0, name:$organizationName0}, {id: $organizationId1, name:$organizationName1}], organizationMenuLang: Lang::get('top-bar.userOrganizations')}
	 *  In case of database connection exception: {"info":organization/organization-management.databaseConnectionException}
	 */
	public function save(array $input)
	{
		try
		{
			$this->DB->connection($input['database_connection_name'])->getDatabaseName();
		}
		catch (\Exception $e)
		{
			$this->Log->warning('An user tried to setup an organization with an non-valid database connection name');

			return json_encode(array('info' => $this->Lang->get('organization/organization-management.databaseConnectionException', array('connection' => $input['database_connection_name']))));
		}

    unset($input['_token'], $input['country'], $input['database'], $input['currency']);
		//unset($input['_token'], $input['country'], $input['database'], $input['currency'], $input['currency_id']);
		$input = array_add($input, 'created_by', $this->AuthenticationManager->getLoggedUserId());
    $input = eloquent_array_filter_for_insert($input);

		$userAppsRecommendations = array();

		$this->DB->transaction(function() use ($input, &$currentUserOrganization, &$userAppsRecommendations)
		{
			$Organization = $this->Organization->create($input);

      $User = $this->User->byId($input['created_by']);
			$this->User->attachOrganizations($input['created_by'], array($Organization->id), $input['created_by'], $User);
			$this->User->attachAllMenus($input['created_by'], $Organization->id, $input['created_by']);
			$this->User->attachAllPermissions($input['created_by'], $Organization->id, $input['created_by']);

			$this->Role->roles()->each(function($Role) use ($input, $Organization)
			{
				$menus = array();

				$this->Role->menusByRole($Role->id)->each(function($Menu) use (&$menus)
				{
					array_push($menus, $Menu->id);
				});

				$OrganizationRole = $this->Role->create(array('name' => $Role->name, 'organization_id' => $Organization->id, 'created_by' => $input['created_by']));
				$this->Role->attachMenus($OrganizationRole->id, $menus, $input['created_by'], $OrganizationRole);
			});

      $Journal = $this->Journal->create(array('journalized_id' => $Organization->id, 'journalized_type' => $this->Organization->getTable(), 'user_id' => $input['created_by']));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('organization/organization-management.organizationAddedJournal', array('organization' => $Organization->name))), $Journal);

			foreach ($this->newOrganizationTrigger as $Trigger)
			{
				$Trigger->run($Organization->id, $Organization->database_connection_name, $userAppsRecommendations);
			}

			$userDefaultOrganizationId = $currentUserOrganization = $this->AuthenticationManager->getLoggedUserDefaultOrganization();

			if(empty($userDefaultOrganizationId))
			{
				$this->AuthenticationManager->setCurrentUserOrganization($Organization);

        $this->User->update(array('default_organization' => $Organization->id), $User);

        $Journal = $this->Journal->create(array('journalized_id' => $input['created_by'], 'journalized_type' => $this->User->getTable(), 'user_id' => $input['created_by'], 'organization_id' => $Organization->id));
        $this->Journal->attachDetail($Journal->id, array('field_lang_key' => 'security/user-management.defaultOrganization', 'new_value' => $Organization->name), $Journal);

				$currentUserOrganization = $Organization->id;
			}
			else
			{
				$currentUserOrganization = $this->AuthenticationManager->getCurrentUserOrganization('id');
			}
		});

		$this->Event->fire(new OnNewInfoMessage(array('message' => '[ORGANIZATION EVENT] A new organization has been added to the system', 'context' => $input), $this->AuthenticationManager));

		$userOrganizations = $this->UserManager->getCountUserOrganizations();

		$successMessage = '<p>' . $this->Lang->get('organization/organization-management.successCreatedOrganizationMessage') . '</p><ul>';

		foreach ($userAppsRecommendations as $key => $recommendation)
		{
			$successMessage .= '<li><a class="fake-link" onclick="setApp(\'' . $recommendation['appName'] . '\')">' . $recommendation['appAction'] . '</a></li>';
		}

		$successMessage .= '</ul>';

		if($userOrganizations == 1)
		{
			return json_encode(array('success' => $successMessage, 'recommendation' => true, 'organizationName' => $input['name'], 'userApps' => $this->UserManager->buildUserMenu(null, $currentUserOrganization, true), 'userActions' => $this->UserManager->getUserActions(null, $currentUserOrganization)));
		}

		if($userOrganizations == 2)
		{
			return json_encode(array('success' => $this->Lang->get('organization/organization-management.successDefaultCreatedOrganizationMessage'), 'organizationMenuTooltip' => true, 'currentUserOrganization' => $currentUserOrganization, 'userOrganizations' => $this->UserManager->getUserOrganizations(), 'organizationMenuLang' => $this->Lang->get('base.userOrganizations')));
		}

		if($userOrganizations > 2 && $userOrganizations < 15)
		{
			return json_encode(array('success' => $this->Lang->get('organization/organization-management.successDefaultCreatedOrganizationMessage'), 'currentUserOrganization' => $currentUserOrganization, 'userOrganizations' => $this->UserManager->getUserOrganizations(), 'organizationMenuLang' => $this->Lang->get('base.userOrganizations')));
		}

		return json_encode(array('success' => $this->Lang->get('organization/organization-management.successDefaultCreatedOrganizationMessage'), 'organizationsAutocomplete' => $this->UserManager->getUserOrganizationsAutocomplete()));
	}

	/**
	 * Update an existing organization
	 *
	 * @param array $input
	 * 	An array as follows: array('id'=>$id, 'name'=>$name, 'street1'=>$street1, 'street2'=>$street2, 'zip_code'=>$zip_code, 'web_site'=>$web_site,
	 * 							   'phone_number'=>$phone_number, 'fax'=>$fax, 'email'=>$email, 'tax_id'=>$tax_id, 'company_registration'=>$company_registration,
	 * 							   'country_id'=>$country_id, 'city_name'=>$city_name, 'state_name'=>$state_name
	 * 						 );
	 *
	 * @return JSON encoded string
	 *  A string as follows: {"success":form.defaultSuccessUpdateMessage, "organizationName":$organizationName, "currentUserOrganization" => $currentUserOrganization, "userOrganizationsUpdated" : [{id: $organizationId0, name:$organizationName0}, {id: $organizationId1, name:$organizationName1}], organizationMenuLang: Lang::get('top-bar.userOrganizations')}
	 */
	public function update(array $input)
	{
    $this->DB->transaction(function() use ($input, &$Organization)
    {
      $Organization = $this->Organization->byId($input['id']);
      $unchangedOrganizationValues = $Organization->toArray();

      unset($input['_token'], $input['country'], $input['currency'], $input['database'], $input['database_connection_name']);
      $input = eloquent_array_filter_for_update($input);
			//var_dump($input);

      $this->Organization->update($input, $Organization);

      $diff = 0;

      foreach ($input as $key => $value)
      {
        if($unchangedOrganizationValues[$key] != $value)
        {
          $diff++;

          if($diff == 1)
          {
            $Journal = $this->Journal->create(array('journalized_id' => $Organization->id, 'journalized_type' => $this->Organization->getTable(), 'user_id' => $this->AuthenticationManager->getLoggedUserId()));
          }

          switch ($key)
          {
            case 'email':
              $fieldLangKey = 'security/user-management.' . camel_case($key);
              break;
            case 'country_id':
              $fieldLangKey = 'organization/organization-management.country';
              $countries = $this->Country->countriesById(array($unchangedOrganizationValues[$key], $value))->toArray();
              foreach ($countries as $index => $country)
              {
                if($country['id'] == $unchangedOrganizationValues[$key])
                {
                  $unchangedOrganizationValues[$key] = $country['name'];
                }

                if($country['id'] == $value)
                {
                  $value = $country['name'];
                }
              }
              break;
						case 'currency_id':
							$fieldLangKey = 'organization/organization-management.currency';
							$currencies = $this->Currency->currenciesById(array($unchangedOrganizationValues[$key], $value))->toArray();
							foreach ($currencies as $index => $currency)
							{
								if($currency['id'] == $unchangedOrganizationValues[$key])
								{
									$unchangedOrganizationValues[$key] = $currency['name'];
								}

								if($currency['id'] == $value)
								{
									$value = $currency['name'];
								}
							}
							break;
            case 'street1':
            case 'street2':
            case 'zip_code':
            case 'city_name':
            case 'state_name':
              $fieldLangKey = 'organization/organization-management.' . camel_case($key) . 'PlaceHolder';
              break;
            default:
              $fieldLangKey = 'organization/organization-management.' . camel_case($key);
          }

          $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get($fieldLangKey), 'field_lang_key' => $fieldLangKey, 'old_value' => $unchangedOrganizationValues[$key], 'new_value' => $value), $Journal);
        }
      }
    });

    $countUserOrganization = $this->UserManager->getCountUserOrganizations();
    $currentUserOrganization = $this->AuthenticationManager->getCurrentUserOrganization('id');
    $userOrganizations = $this->UserManager->getUserOrganizations();

		if($currentUserOrganization == $Organization->id)
		{
			$this->AuthenticationManager->setCurrentUserOrganization($Organization);
			$organizationName = $input['name'];
		}
		else
		{
			$organizationName = $this->AuthenticationManager->getCurrentUserOrganization('name');
		}

		if($countUserOrganization == 1)
		{
			return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage'), 'organizationName' => $organizationName));
		}
		else if($userOrganizations > 2 && $userOrganizations < 15)
		{
			return json_encode(array('success' => $this->Lang->get('form.defaultSuccessUpdateMessage'), 'organizationName' => $organizationName, 'currentUserOrganization' => $currentUserOrganization, 'userOrganizations' => $userOrganizations, 'organizationMenuLang' => $this->Lang->get('base.userOrganizations')));
		}
		else
		{
			return json_encode(array('success' => $this->Lang->get('form.defaultSuccessUpdateMessage'), 'organizationsAutocomplete' => $this->UserManager->getUserOrganizationsAutocomplete()));
		}
	}

	/**
	 * Delete existing organizations (soft delete)
	 *
	 * @param array $input
	 * 	An array as follows: array($id0, $id1,…);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success and user has cero organization: {"reload":true}
	 *	In case of success and current user organization has been deleted: {"reload":true}
	 *	In case of success and user has one organization: {"success":form.defaultSuccessUpdateMessage, "deleteOrganizationMenu":true}
	 *	In case of success and user has more than one organization: {"success":form.defaultSuccessUpdateMessage, "currentUserOrganization" => $currentUserOrganization, "userOrganizations" : [{id: $organizationId0, name:$organizationName0}, {id: $organizationId1, name:$organizationName1}], organizationMenuLang: Lang::get('top-bar.userOrganizations')}
	 */
	public function delete(array $input)
	{
		$response = array();
		$count = 0;

		$this->DB->transaction(function() use ($input, &$countUserOrganizations, &$currentUserOrganization, &$response, &$count)
		{
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();

			foreach ($input['id'] as $key => $id)
			{
				$count++;

				$Organization = $this->Organization->byId($id);

				$Journal = $this->Journal->create(array('journalized_id' => $Organization->id, 'journalized_type' => $this->Organization->getTable(), 'user_id' => $loggedUserId));
				$this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('organization/organization-management.organizationDeletedJournal', array('organization' => $Organization->name))), $Journal);

        $this->User->byDynamicWhere(array('default_organization' => $id))->each(function($User) use($Journal, $loggedUserId, $input)
        {

					$Journal = $this->Journal->create(array('journalized_id' => $User->id, 'journalized_type' => $this->User->getTable(), 'user_id' => $loggedUserId));

					//Modificar para que no cuente las que se estan eliminando
          if( ($this->UserManager->getCountUserOrganizations($User->id) - 1) == 0)
          {
            $this->UserManager->deactivateUser($User, $Journal);
          }
          else
          {
            $this->UserManager->setFirstOrganizationAvailableToUser($User, $Journal, null, $input['id']);
          }
        });
			}

			$this->Organization->delete($input['id']);

			$countUserOrganizations = $this->UserManager->getCountUserOrganizations($loggedUserId);

			if(in_array($this->AuthenticationManager->getCurrentUserOrganization('id'), $input['id']))
			{
				$this->AuthenticationManager->unsetCurrentUserOrganization();

				if($countUserOrganizations > 0)
				{
					$User = $this->User->byId($loggedUserId);

					$this->AuthenticationManager->setCurrentUserOrganization($this->Organization->byId($User->default_organization));
				}

				$response = array('reload' => true);
			}
		});

    if($count == 1)
    {
      $successMessage = $this->Lang->get('organization/organization-management.successDeletedOrganizationMessage');
    }
    else
    {
      $successMessage = $this->Lang->get('organization/organization-management.successDeletedOrganizationsMessage');
    }

		if(empty($response))
		{
			if($countUserOrganizations <= 1)
			{
				return json_encode(array('success' => $successMessage, "deleteOrganizationMenu" => true));
			}

			return json_encode(array('success' => $successMessage, 'currentUserOrganization' => $currentUserOrganization, 'userOrganizations' => $this->UserManager->getUserOrganizations(), 'organizationMenuLang' => $this->Lang->get('base.userOrganizations')));
		}
		else
		{
			return json_encode($response);
		}
	}
}

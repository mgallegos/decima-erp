<?php
/**
 * @file
 * App Manager Service.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Services\AppManagement;

use Illuminate\Config\Repository;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Kwaai\Security\Repositories\User\UserInterface;

use Illuminate\Auth\AuthManager;

use App\Kwaai\Security\Repositories\Module\ModuleInterface;

use App\Kwaai\Security\Repositories\Menu\MenuInterface;

use Illuminate\Routing\UrlGenerator;

use Symfony\Component\Translation\TranslatorInterface;

class AppManager implements AppManagementInterface {

	/**
	 * Authentication Management Interface
	 *
	 * @var App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface
	 *
	 */
	protected $AuthenticationManager;

	/**
	 * Laravel Translator instance
	 *
	 * @var \Symfony\Component\Translation\TranslatorInterface
	 *
	 */
	protected $Lang;

	/**
	 * The URL generator instance
	 *
	 * @var \Illuminate\Routing\UrlGenerator
	 *
	 */
	protected $Url;

	/**
	 * Laravel Authenticator instance
	 *
	 * @var \Illuminate\Auth\AuthManager
	 *
	 */
	protected $Auth;

	/**
	 * Menu
	 *
	 * @var App\Kwaai\Security\Repositories\Menu\MenuInterface
	 *
	 */
	protected $Menu;

	/**
	 * Module
	 *
	 * @var App\Kwaai\Security\Repositories\Module\ModuleInterface
	 *
	 */
	protected $Module;

	/**
	 * User
	 *
	 * @var App\Kwaai\Security\Repositories\User\UserInterface
	 *
	 */
	protected $User;

	/**
	 * Laravel Repository instance
	 *
	 * @var Illuminate\Config\Repository
	 *
	 */
	protected $Config;


	public function __construct(AuthenticationManagementInterface $AuthenticationManager, TranslatorInterface $Lang, UrlGenerator $Url, Repository $Config, MenuInterface $Menu, ModuleInterface $Module, UserInterface $User)
	{
		$this->AuthenticationManager = $AuthenticationManager;

		$this->Lang = $Lang;

		$this->Url = $Url;

		$this->Menu = $Menu;

		$this->Module = $Module;

		$this->User = $User;

		$this->Config = $Config;
	}

	/**
	 * Get system name
	 *
	 * @return string
	 *
	 */
	public function getSystemName()
	{
		return $this->Config->get('system-security.system_name');
	}

	/**
	* Get system icon
	*
	* @return string
	*
	*/
	public function getSystemIcon()
	{
		return $this->Config->get('system-security.system_icon');
	}

	/**
	* Get brand URL
	*
	* @return string
	*
	*/
	public function getBrandUrl()
	{
		return $this->Config->get('system-security.brand_url');
	}

	/**
	 * Get application information
	 *
	 * @return array
	 *  An array as follows: array('id'=>$id, 'url'=>$url, 'name'=>$name, 'breadcrumb'=>array($module, $subModule,…))
	 */
	public function getAppInfo()
	{
		$url = str_replace($this->Url->to('/'), '', $this->Url->current());

		if(strpos($url, '/cms') !== false)
		{
			return;
		}

		if($url == '/' . $this->getLoginPageUrl() || strpos($url,'/' . $this->getPasswordReminderPageUrl()) !== false || strpos($url,'/' . $this->getPasswordResetPageUrl()) !== false || strpos($url,'/' . $this->getUserActivationPageUrl()) !== false || strpos($url,'/' . $this->getErrorPageUrl()) !== false)
		{
			return;
		}

		if($url == '/' . $this->getInitialSetupPageUrl())
		{
			return array('id' => 'initial-setup', 'url' => '/initial-setup', 'name' => $this->Lang->get('initial-setup.appName'), 'breadcrumb' => array($this->getSystemName(), $this->Lang->get('initial-setup.appName')));
		}

		if($url == '/' . $this->getUserPreferencesPageUrl())
		{
			return array('id' => 'user-preferences', 'url' => $url, 'name' => $this->Lang->get('user-preferences.appName'), 'breadcrumb' => array($this->getSystemName(), $this->Lang->get('user-preferences.appName')));
		}

		if($this->Url->to('/dashboard') == $this->Url->current())
		{
			return array('id' => 'dashboard', 'url' => '/', 'name' => $this->Lang->get('dashboard.appName'), 'breadcrumb' => array($this->getSystemName(), $this->Lang->get('dashboard.appName')));
		}

		$Menu = $this->Menu->menuByUrl($url);

		$urlElements = explode('/', $Menu[0]->url);

		$parentMenus = $this->Menu->parentMenusByModule( $Menu[0]->module_id );

		$breadcrumb = array();

		$this->getParent($Menu[0]->parent_id, $breadcrumb, $parentMenus->toArray());

		array_push($breadcrumb, $this->Lang->has($Menu[0]->lang_key) ? $this->Lang->get($Menu[0]->lang_key) : $Menu[0]->name);

		return array('id' => $urlElements[count($urlElements) -1], 'url' => $Menu[0]->url, 'name'=>($this->Lang->has($Menu[0]->lang_key) ? $this->Lang->get($Menu[0]->lang_key) : $Menu[0]->name), 'breadcrumb' => $breadcrumb);
	}

	/**
	 * Get the login page URL.
	 *
	 * @return string
	 */
	public function getLoginPageUrl()
	{
		return 'login';
	}

	/**
	 * Get the initial setup page URL.
	 *
	 * @return string
	 */
	public function getInitialSetupPageUrl()
	{
		return 'initial-setup';
	}

	/**
	 * Get the user preference page URL.
	 *
	 * @return string
	 */
	public function getUserPreferencesPageUrl()
	{
		return 'user-preferences';
	}

	/**
	 * Get the password reminder page URL.
	 *
	 * @return string
	 */
	public function getPasswordReminderPageUrl()
	{
		return 'password-reminder';
	}

	/**
	 * Get the password reset page URL.
	 *
	 * @return string
	 */
	public function getPasswordResetPageUrl()
	{
		return 'password-reset';
	}

	/**
	 * Get the user activation page URL.
	 *
	 * @return string
	 */
	public function getUserActivationPageUrl()
	{
		return 'user-activation';
	}

	/**
	 * Get error page URL.
	 *
	 * @return string
	 */
	public function getErrorPageUrl()
	{
		return 'error';
	}

	/**
	 * Get the Organization Management app URL.
	 *
	 * @return string
	 */
	public function getOrganizationManagementAppUrl()
	{
		return 'general-setup/organization/organization-management';
	}

	/**
	 * Get the Organization Management app URL.
	 *
	 * @return string
	 */
	public function getNewOrganizationManagementAppUrl()
	{
		return 'general-setup/organization/organization-management/new';
	}

	/**
	 * Verify if an user is trying to access the initial setup page.
	 *
	 * @return boolean
	 */
	public function isInitialSetupPage()
	{
		if(('/' . $this->getInitialSetupPageUrl()) == str_replace($this->Url->to('/'), '', $this->Url->current()))
		{
			return true;
		}

		return false;
	}


	/**
	 * Verify if an user is trying to access the Organization Management app.
	 *
	 * @return boolean
	 */
	public function isOrganizationManagementApp()
	{
		if(('/' . $this->getOrganizationManagementAppUrl()) == str_replace($this->Url->to('/'), '', $this->Url->current()))
		{
			return true;
		}

		return false;
	}

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
	public function isUserClearToAccessApp($userId = null, $url = null, $organizationId = null)
	{
		if(empty($userId))
		{
			$userId = $this->AuthenticationManager->getLoggedUserId();
		}

		if($this->AuthenticationManager->isUserRoot($userId))
		{
			return true;
		}

		if(empty($url))
		{
			$Menu = $this->Menu->menuByUrl(str_replace($this->Url->to('/'), '', $this->Url->current()));
		}
		else
		{
			$Menu = $this->Menu->menuByUrl($url);
		}

		if(empty($organizationId))
		{
			$organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');
		}

		if($Menu->isEmpty())
		{
			return false;
		}

		$userMenus = array();

		$this->User->menusByUserRolesByModuleAndByOrganization($userId, $Menu[0]->module_id, $organizationId)->each(function($menu)  use (&$userMenus)
		{
			$userMenus = array_add($userMenus, $menu->id, $menu->name);
		});

		$this->User->menusByUserByModuleAndByOrganization($userId, $Menu[0]->module_id, $organizationId)->each(function($menu) use (&$userMenus)
		{
			if(!$menu->pivot->is_assigned && isset($userMenus[$menu->id]))
			{
				unset($userMenus[$menu->id]);
			}

			if($menu->pivot->is_assigned)
			{
				$userMenus = array_add($userMenus, $menu->id, $menu->name);
			}
		});

		if(isset($userMenus[$Menu[0]->id]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Get menu's parents.
	 *
	 * @param  array &$apps
	 * @param  array $parentMenus
	 *
	 * @return void
	 */
	public function getParent($menuParentId, &$breadcrumb, $parentMenus)
	{
		$parentMenusCopy = $parentMenus;

		foreach ($parentMenus as $index => $menu)
		{
			if($menu['id'] == $menuParentId)
			{
				if(!empty($menu['parent_id']))
				{
					$this->getParent($menu['parent_id'], $breadcrumb, $parentMenusCopy);

					array_push($breadcrumb, $this->Lang->has($menu['lang_key']) ? $this->Lang->get($menu['lang_key']) : $menu['name']);
				}
				else
				{
					$Module = $this->Module->byId($menu['module_id']);
					array_push($breadcrumb, $this->Lang->has($Module->lang_key) ? $this->Lang->get($Module->lang_key) : $Module->name);

					array_push($breadcrumb, $this->Lang->has($menu['lang_key']) ? $this->Lang->get($menu['lang_key']) : $menu['name']);

				}
			}
		}
	}

}

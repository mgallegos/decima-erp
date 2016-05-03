<?php
/**
 * @file
 * SEC_User Table Seeder
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
namespace Mgallegos\DecimaAccounting\Accounting\Triggers;

use Illuminate\Routing\UrlGenerator;

use Illuminate\Translation\Translator;

use App\Kwaai\Organization\Repositories\Organization\NewOrganizationTriggerInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface;


class NewOrganizationTrigger implements NewOrganizationTriggerInterface {

	/**
	* Setting
	*
	* @var Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface
	*
	*/
	protected $Setting;

	/**
	* URL
	*
	* @var Illuminate\Routing\UrlGenerator
	*
	*/
	protected $URL;

	/**
	* Lang
	*
	* @var Illuminate\Translation\Translator
	*
	*/
	protected $Lang;

	public function __construct(SettingInterface $Setting, UrlGenerator $URL, Translator $Lang)
	{
			$this->Setting = $Setting;

			$this->URL = $URL;

			$this->Lang = $Lang;
	}

/**
	* This method will be executed after an organization has been created.
	*
	* @param integer $id
	* 	Organization id
	* @param string $databaseConnectionName
	* 	Database connection name of the organization
	* @param array $userAppsRecommendations
	* 	An array as follows: array('appName'=>$appName, 'appAction'=>$appAction)
	*
	* @return void
	*/
	public function run($id, $databaseConnectionName, &$userAppsRecommendations)
	{
		$this->Setting->changeDatabaseConnection($databaseConnectionName);
		$this->Setting->create(array('organization_id' => $id));

		array_push($userAppsRecommendations, array('appName' => $this->Lang->get('decima-accounting::menu.initialAccountingSetup'), 'appAction' => $this->Lang->get('decima-accounting::initial-accounting-setup.action')));
	}

}

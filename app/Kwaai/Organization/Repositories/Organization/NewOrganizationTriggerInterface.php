<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Organization\Repositories\Organization;

interface NewOrganizationTriggerInterface {

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
	public function run($id, $databaseConnectionName, &$userAppsRecommendations);
}

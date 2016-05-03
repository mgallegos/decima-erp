<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Organization\Repositories\Organization;

use App\Kwaai\Security\Services\UserManagement\UserManagementInterface;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use Illuminate\Database\DatabaseManager as DatabaseManager;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class EloquentOrganizationGridRepository extends EloquentRepositoryAbstract {

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager)
	{
		$this->Database = $DB->table('ORG_Organization AS o')
								->join('SYS_Country AS s', 's.id', '=', 'o.country_id')
								->join('SYS_Currency AS c', 'c.id', '=', 'o.currency_id')
								->join('SEC_User AS u', 'u.id', '=', 'o.created_by')
								->whereNull('o.deleted_at');

		if(!$AuthenticationManager->isUserRoot())
		{
			$this->Database->where('o.created_by', '=', $AuthenticationManager->getLoggedUserId());
		}

		$this->visibleColumns = array('o.id', 'o.name', 'o.tax_id', 'o.company_registration', 's.name AS country', 'o.database_connection_name',
									   							'o.street1', 'o.street2', 'o.zip_code', 'o.web_site', 'o.phone_number', 'o.fax', 'o.email', 'o.country_id',
									   							'o.city_name', 'o.state_name', 'u.email AS user_email', 'o.currency_id', 'c.name AS currency', 'c.symbol AS symbol'
		);

		$this->orderBy = array(array('o.id', 'asc'));
	}

}

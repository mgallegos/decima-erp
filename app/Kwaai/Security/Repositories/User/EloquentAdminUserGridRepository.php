<?php
/**
 * @file
 * Eloquent Admin User Grid Repository
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\User;

use Illuminate\Config\Repository;

use App\Kwaai\Security\Services\UserManagement\UserManagementInterface;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use Illuminate\Database\DatabaseManager as DatabaseManager;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class EloquentAdminUserGridRepository extends EloquentRepositoryAbstract {

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager)
	{
		$this->Database = $DB->table('SEC_User AS u')
								->leftJoin('SEC_User AS uc', 'uc.id', '=', 'u.created_by')
								->where('u.is_admin', '=', true)
								->where('u.id', '!=', $AuthenticationManager->getLoggedUserId())
								->whereNull('u.deleted_at');

		if(!$AuthenticationManager->isUserRoot())
		{
			$this->Database->where('u.created_by', '=', $AuthenticationManager->getLoggedUserId());
		}

		$this->visibleColumns = array('u.id', 'u.firstname', 'u.lastname', 'u.email', 'u.timezone', 'u.is_active', 'uc.email AS created_by');

		$this->orderBy = array(array('u.id', 'asc'));
	}

}

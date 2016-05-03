<?php
/**
 * @file
 * Eloquent User Grid Repository
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\User;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use Illuminate\Database\DatabaseManager as DatabaseManager;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class EloquentUserGridRepository extends EloquentRepositoryAbstract {

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager)
	{
		$this->Database = $DB->table('SEC_User AS u')
								->join('SEC_User_Organization AS uo', 'uo.user_id', '=', 'u.id')
								->leftJoin('SEC_User AS uc', 'uc.id', '=', 'u.created_by')
								->where('uo.organization_id', '=', $AuthenticationManager->getCurrentUserOrganization('id'))
								->whereNull('u.deleted_at');

		$this->visibleColumns = array('u.id', 'u.firstname', 'u.lastname', 'u.email', 'u.timezone', 'u.is_active', 'uc.email AS created_by');

		$this->orderBy = array(array('u.id', 'asc'));
	}

}

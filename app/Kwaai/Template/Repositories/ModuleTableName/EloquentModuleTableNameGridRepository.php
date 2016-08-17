<?php
/**
 * @file
 * Description of the script.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Vendor\DecimaModule\Module\Repositories\ModuleTableName;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use Illuminate\Database\DatabaseManager;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

use Illuminate\Translation\Translator;

class EloquentModuleTableNameGridRepository extends EloquentRepositoryAbstract {

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager)
	{
		// $this->DB = $DB;
		// $this->DB->connection()->enableQueryLog();

		$this->Database = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('MODULE_Table1 AS t1')
								->leftJoin('MODULE_Table1 AS t1p', 't1.id', '=', 't1p.parent_id')
								->join('MODULE_Table2 AS t2', 't2.id', '=', 't1.table2_id')
								->where('t.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereNull('t.deleted_at');

		$this->visibleColumns = array('t1.id AS module_app_id', $DB->raw('CASE t1.field0 WHEN 1 THEN 0 ELSE 1 END AS module_app_field0'),
																);

		$this->orderBy = array(array('module_app_id', 'asc'));

		// $this->treeGrid = true;

		// $this->parentColumn = 'parent_id';

		// $this->leafColumn = 'is_leaf';
	}

}

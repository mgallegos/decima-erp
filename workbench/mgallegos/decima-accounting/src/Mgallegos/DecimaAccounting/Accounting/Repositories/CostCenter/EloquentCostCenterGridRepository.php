<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use Illuminate\Database\DatabaseManager as DatabaseManager;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

use Illuminate\Translation\Translator;

class EloquentCostCenterGridRepository extends EloquentRepositoryAbstract {

	/**
	 * Tree Grid Flag
	 *
	 * @var Boolean
	 *
	 */
	protected $treeGrid;

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager, Translator $Lang)
	{
		// $this->DB = $DB;
		// $this->DB->connection()->enableQueryLog();

		$this->Database = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Cost_Center AS c')
								->leftJoin('ACCT_Cost_Center AS cp', 'cp.id', '=', 'c.parent_cc_id')
								->where('c.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereNull('c.deleted_at');

		$this->visibleColumns = array('c.id AS acct_ccm_id', 'c.key as acct_ccm_key', 'c.name as acct_ccm_name', 'c.is_group as acct_ccm_is_group',
																	'cp.id as acct_ccm_parent_cc_id', 'cp.key as acct_ccm_parent_key', 'cp.name as acct_ccm_parent_cc',
																	$DB->raw('CASE c.is_group WHEN 1 THEN 0 ELSE 1 END AS acct_ccm_is_leaf'),
																);

		$this->orderBy = array(array('acct_ccm_key', 'asc'));

		$this->treeGrid = true;

		$this->parentColumn = 'cp.id';

		$this->leafColumn = 'acct_ccm_is_leaf';
	}

}

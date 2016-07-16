<?php
/**
 * @file
 * Description of the script.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use Illuminate\Database\DatabaseManager;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

use Illuminate\Translation\Translator;

class EloquentFiscalYearGridRepository extends EloquentRepositoryAbstract {

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager)
	{
		// $this->DB = $DB;
		// $this->DB->connection()->enableQueryLog();

		$this->Database = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Fiscal_Year AS f')
								->where('f.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereNull('f.deleted_at');

		$this->visibleColumns = array('f.id AS acct_cfy_id', 'f.year AS acct_cfy_year', 'f.start_date AS acct_cfy_start_date', 'f.end_date AS acct_cfy_end_date');

		$this->orderBy = array(array('acct_cfy_id', 'asc'));
	}

}

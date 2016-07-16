<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\Period;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use Illuminate\Database\DatabaseManager as DatabaseManager;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

use Illuminate\Translation\Translator;

class EloquentPeriodGridRepository extends EloquentRepositoryAbstract {

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager, Translator $Lang)
	{
		// $this->DB = $DB;
		// $this->DB->connection()->enableQueryLog();

		$this->Database = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Period AS p')
								->join('ACCT_Fiscal_Year AS f', 'f.id', '=', 'p.fiscal_year_id')
								->where('p.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereNull('p.deleted_at');

		$this->visibleColumns = array('p.id AS acct_pm_id', 'p.month as acct_pm_month', 'p.start_date as acct_pm_start_date', 'p.end_date as acct_pm_end_date', 'p.is_closed as acct_pm_is_closed', 'f.year as acct_pm_year');

		$this->orderBy = array(array('acct_pm_year', 'desc'), array('acct_pm_month', 'asc'));
	}

}

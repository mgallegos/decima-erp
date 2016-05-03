<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use Illuminate\Database\DatabaseManager as DatabaseManager;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class EloquentJournalEntryGridRepository extends EloquentRepositoryAbstract {

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager)
	{

		$this->Database = $DB->table('ACCT_Journal_Entry AS je')
					->join('ACCT_Cost_Center AS cc', 'cc.id', '=', 'je.cost_center_id')
					->join('ACCT_Account AS c', 'c.id', '=', 'je.account_id')
					->where('c.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
					->where('cc.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
					->whereNull('je.deleted_at');

		$this->visibleColumns = array('je.id AS journal_entry_id', 'je.debit', 'je.credit', 'je.journal_voucher_id',
																	'cc.id AS cost_center_id', 'cc.key AS cost_center_key', 'cc.name AS cost_center_name',
																	'c.id AS account_id', 'c.key AS account_key', 'c.name AS account_name'
		);

		$this->orderBy = array(array('je.id', 'asc'));
	}

}

<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\Account;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use Illuminate\Database\DatabaseManager as DatabaseManager;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

use Illuminate\Translation\Translator;

class EloquentAccountGridRepository extends EloquentRepositoryAbstract {

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
								->table('ACCT_Account AS a')
								->leftJoin('ACCT_Account AS ap', 'ap.id', '=', 'a.parent_account_id')
								->join('ACCT_Account_Type AS at', 'at.id', '=', 'a.account_type_id')
								->where('a.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereNull('a.deleted_at');

		$this->visibleColumns = array('a.id AS acct_am_id', 'a.key as acct_am_key', 'a.name as acct_am_name', 'a.balance_type as acct_am_balance_type',
																	'a.is_group as acct_am_is_group', 'a.account_type_id as acct_am_account_type_id', 'at.name as acct_am_account_type',
																	'ap.id as acct_am_parent_account_id', 'ap.key as acct_am_parent_key', 'ap.name as acct_am_parent_account',/*$DB->raw('0 as level'),*/
																	$DB->raw('CASE a.balance_type WHEN "D" THEN "' . $Lang->get('decima-accounting::account-management.D') . '" ELSE "' . $Lang->get('decima-accounting::account-management.A') . '" END AS acct_am_balance_type_name'),
																	$DB->raw('CASE a.is_group WHEN 1 THEN 0 ELSE 1 END AS acct_am_is_leaf'),
																);

		$this->orderBy = array(array('acct_am_key', 'asc'));

		$this->treeGrid = true;

		$this->parentColumn = 'ap.id';

		$this->leafColumn = 'acct_am_is_leaf';
	}

}

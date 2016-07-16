<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use Illuminate\Database\DatabaseManager as DatabaseManager;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

use Illuminate\Translation\Translator;

class EloquentJournalVoucherGridRepository extends EloquentRepositoryAbstract {

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager, Translator $Lang)
	{
		/*
		$this->Database = $DB->table('ACCT_Journal_Voucher AS jv')
								->join('ACCT_Voucher_Type AS vt', 'vt.id', '=', 'jv.voucher_type_id')
								->where('jv.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereNull('jv.deleted_at');

		$this->visibleColumns = array('jv.id', 'jv.number', 'jv.date', 'jv.manual_reference', 'jv.remark', 'jv.is_editable', 'jv.status',
																	'vt.name', 'vt.lang_key',
		);
		*/

		//$DB->connection()->enableQueryLog();

		// $this->DB = $DB;
		//
		// $this->DB->connection()->enableQueryLog();


		$this->Database = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Journal_Voucher AS jv')
								->leftJoin('ACCT_Journal_Entry AS je', 'je.journal_voucher_id', '=', 'jv.id')
								->join('ACCT_Voucher_Type AS vt', 'vt.id', '=', 'jv.voucher_type_id')
								->join('ACCT_Period AS p', 'p.id', '=', 'jv.period_id')
								->leftJoin('ACCT_Cost_Center AS cc', 'cc.id', '=', 'je.cost_center_id')
								->leftJoin('ACCT_Account AS c', 'c.id', '=', 'je.account_id')
								->where('jv.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereNull('je.deleted_at')
								->whereNull('jv.deleted_at');

		$this->visibleColumns = array('jv.id AS voucher_id', 'jv.number', 'jv.date', 'jv.manual_reference', 'jv.remark', 'jv.is_editable', 'jv.status',
																	/*'je.id AS journal_entry_id',*/ 'je.debit AS debit_0', 'je.credit AS credit_0',
																	'vt.id AS voucher_type_id', 'vt.name AS voucher_type',
																	'cc.id AS cost_center_id_0', 'cc.key AS cost_center_key_0', 'cc.name AS cost_center_name_0',
																	'c.id AS account_id_0', 'c.key AS account_key_0', 'c.name AS account_name_0',
																	'p.id AS period_id',
																	// $DB->raw('CONCAT("#", CASE WHEN jv.number < 10 THEN LPAD(jv.number, 2, 0) ELSE jv.number END, " - ", DATE_FORMAT(jv.date, "' . $Lang->get('form.mysqlDateFormat') . '"), " - ", vt.name, " - ", IFNULL(jv.manual_reference,"' . $Lang->get('decima-accounting::journal-management.noRef') . '"), " - ", jv.remark) AS voucher_header')
																	$DB->raw('CONCAT("#", LPAD(jv.number, 4, 0), " - P", LPAD(month, 2, 0), " - ", DATE_FORMAT(jv.date, "' . $Lang->get('form.mysqlDateFormat') . '"), " - ", vt.name, " - ", IFNULL(jv.manual_reference,"' . $Lang->get('decima-accounting::journal-management.noRef') . '"), " - ", jv.remark) AS voucher_header')
																	// $DB->raw('CASE
																	// 						WHEN jv.number < 10 THEN CONCAT(" ", DATE_FORMAT(jv.date, "%c"), " - ", DATE_FORMAT(jv.date, "' . $Lang->get('form.mysqlDateFormat') . '"), " - #", jv.number, " - ", vt.name, " - ", IFNULL(jv.manual_reference,"' . $Lang->get('decima-accounting::journal-management.noRef') . '"), " - ", jv.remark)
																	// 						ELSE CONCAT(" ", DATE_FORMAT(jv.date, "%c"), " - ", DATE_FORMAT(jv.date, "' . $Lang->get('form.mysqlDateFormat') . '"), " - #", jv.number, " - ", vt.name, " - ", IFNULL(jv.manual_reference,"' . $Lang->get('decima-accounting::journal-management.noRef') . '"), " - ", jv.remark)
																	// 					END AS voucher_header')
																	//$DB->raw('count(*) AS voucher_header')
		);


		//var_dump($DB->raw('CONCAT(jv.date, ' - ', jv.number, ' - ', vt.name) AS voucher_header'));die();
		//var_dump($DB->raw('concat(jv.date, " - ", jv.number) AS voucher_header'));die();

		$this->orderBy = array(array('voucher_header', 'desc'));

	}
}

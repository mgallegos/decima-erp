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

use Illuminate\Translation\Translator;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class EloquentBalanceSheetGridRepository extends EloquentRepositoryAbstract {

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager, Translator $Lang)
	{
		$this->DB = $DB;

		$this->AuthenticationManager = $AuthenticationManager;

		//$this->DB->connection()->enableQueryLog();

		/*
		$this->Database = $DB->table('ACCT_Journal_Entry AS je')
								->join('ACCT_Journal_Voucher AS jv', 'jv.id', '=', 'je.journal_voucher_id')
								->rightJoin('ACCT_Account AS c', 'je.account_id', '=', 'c.id')
								->join('ACCT_Account_Type AS at', 'at.id', '=', 'c.account_type_id')
								->where(function($query)
				                {
				                  $query->orWhere('jv.status', '=', 'B');
				                  $query->orWhereNull('jv.status');
				                }
								)
								->where('c.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereIn('at.pl_bs_category', array('D', 'E'))
								->whereNull('je.deleted_at')
								->whereNull('jv.deleted_at');
								//->groupBy('c.id', 'c.parent_account_id', 'c.key', 'c.name', 'at.name');

		$this->visibleColumns = array($DB->raw('IFNULL(SUM(je.debit),0) AS acct_bs_debit'), $DB->raw('IFNULL(SUM(je.credit),0) AS acct_bs_credit'),
																	'c.id AS acct_bs_account_id', 'c.parent_account_id AS acct_bs_parent_account_id','c.key AS acct_bs_account_key', 'c.name AS acct_bs_account_name', 'c.is_group AS acct_bs_is_group', 'c.balance_type AS acct_bs_balance_type',
																	$DB->raw('CASE at.pl_bs_category WHEN "D" THEN "' . $Lang->get('decima-accounting::balance-sheet.assets') . '" ELSE "' . $Lang->get('decima-accounting::balance-sheet.liability') . '" END AS acct_bs_pl_bs_category'),
																	//$DB->raw('CASE balance_type WHEN "D" THEN IFNULL(SUM(je.debit),0) - IFNULL(SUM(je.credit),0) ELSE IFNULL(SUM(je.credit),0) - IFNULL(SUM(je.debit),0) END AS acct_bs_balance'),
																	$DB->raw('0 AS acct_bs_balance'),
																	//'at.name AS acct_bs_account_type_name'
																	//$DB->raw('CONCAT(" ", DATE_FORMAT(jv.date, "%c"), " - ", DATE_FORMAT(jv.date, "' . $Lang->get('form.mysqlDateFormat') . '"), " - #", jv.number, " - ", vt.name, " - ", IFNULL(jv.manual_reference,"No Ref."), " - ", jv.remark) AS voucher_header')
																	//$DB->raw('count(*) AS voucher_header')
		);
		*/

		$this->Database = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Journal_Entry AS je')
								->join('ACCT_Journal_Voucher AS jv', 'jv.id', '=', 'je.journal_voucher_id')
								->rightJoin('ACCT_Account AS c', 'je.account_id', '=', 'c.id')
								->join('ACCT_Account_Type AS at', 'at.id', '=', 'c.account_type_id')
								->where('jv.status', '=', 'B')
								->where('c.is_group', '=', 0)
								->where('jv.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereIn('at.pl_bs_category', array('D', 'E'))
								->whereNull('je.deleted_at')
								->whereNull('jv.deleted_at');
								//->groupBy('c.id', 'c.parent_account_id', 'c.key', 'c.name', 'at.name');

		$this->visibleColumns = array($DB->raw('IFNULL(SUM(je.debit),0) AS acct_bs_debit'), $DB->raw('IFNULL(SUM(je.credit),0) AS acct_bs_credit'),
																	'c.id AS acct_bs_account_id', 'c.parent_account_id AS acct_bs_parent_account_id','c.key AS acct_bs_account_key', 'c.name AS acct_bs_account_name', 'c.is_group AS acct_bs_is_group', 'c.balance_type AS acct_bs_balance_type',
																	$DB->raw('CASE at.pl_bs_category WHEN "D" THEN "' . $Lang->get('decima-accounting::balance-sheet.assets') . '" ELSE "' . $Lang->get('decima-accounting::balance-sheet.liability') . '" END AS acct_bs_pl_bs_category'),
																	//$DB->raw('CASE balance_type WHEN "D" THEN IFNULL(SUM(je.debit),0) - IFNULL(SUM(je.credit),0) ELSE IFNULL(SUM(je.credit),0) - IFNULL(SUM(je.debit),0) END AS acct_bs_balance'),
																	$DB->raw('0 AS acct_bs_balance'),
																	//'at.name AS acct_bs_account_type_name'
																	//$DB->raw('CONCAT(" ", DATE_FORMAT(jv.date, "%c"), " - ", DATE_FORMAT(jv.date, "' . $Lang->get('form.mysqlDateFormat') . '"), " - #", jv.number, " - ", vt.name, " - ", IFNULL(jv.manual_reference,"No Ref."), " - ", jv.remark) AS voucher_header')
																	//$DB->raw('count(*) AS voucher_header')
		);

		$this->Database2 = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Journal_Entry AS je')
								->join('ACCT_Journal_Voucher AS jv', 'jv.id', '=', 'je.journal_voucher_id')
								->rightJoin('ACCT_Account AS c', 'je.account_id', '=', 'c.id')
								->join('ACCT_Account_Type AS at', 'at.id', '=', 'c.account_type_id')
								->where(function($query)
				                {
				                  $query->orWhere('jv.status', '=', 'B');
				                  $query->orWhereNull('jv.status');
				                }
								)
								->where('jv.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereIn('at.pl_bs_category', array('B'))
								->whereNull('je.deleted_at')
								->whereNull('jv.deleted_at');

		$this->Database4 = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Journal_Entry AS je')
								->join('ACCT_Journal_Voucher AS jv', 'jv.id', '=', 'je.journal_voucher_id')
								->rightJoin('ACCT_Account AS c', 'je.account_id', '=', 'c.id')
								->join('ACCT_Account_Type AS at', 'at.id', '=', 'c.account_type_id')
								->where(function($query)
				                {
				                  $query->orWhere('jv.status', '=', 'B');
				                  $query->orWhereNull('jv.status');
				                }
								)
								->where('jv.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereIn('at.pl_bs_category', array('C'))
								->whereNull('je.deleted_at')
								->whereNull('jv.deleted_at');

		$this->Database3 = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Account AS c')
								->join('ACCT_Account_Type AS at', 'at.id', '=', 'c.account_type_id')
								->where('c.is_group', '=', 1)
								->where('c.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->whereIn('at.pl_bs_category', array('D', 'E'))
								->select(array($DB->raw('0 AS acct_bs_debit'), $DB->raw('0 AS acct_bs_credit'),
												'c.id AS acct_bs_account_id', 'c.parent_account_id AS acct_bs_parent_account_id','c.key AS acct_bs_account_key', 'c.name AS acct_bs_account_name', 'c.is_group AS acct_bs_is_group', 'c.balance_type AS acct_bs_balance_type',
												$DB->raw('CASE at.pl_bs_category WHEN "D" THEN "' . $Lang->get('decima-accounting::balance-sheet.assets') . '" ELSE "' . $Lang->get('decima-accounting::balance-sheet.liability') . '" END AS acct_bs_pl_bs_category'),
												$DB->raw('0 AS acct_bs_balance'),
												)
								);



		$this->orderBy = array(array('acct_bs_account_key', 'asc'));
	}

	/**
	* Calculate the number of rows. It's used for paging the result.
	*
	* @param  array $filters
	*  An array of filters, example: array(array('field'=>'column index/name 1','op'=>'operator','data'=>'searched string column 1'), array('field'=>'column index/name 2','op'=>'operator','data'=>'searched string column 2'))
	*  The 'field' key will contain the 'index' column property if is set, otherwise the 'name' column property.
	*  The 'op' key will contain one of the following operators: '=', '<', '>', '<=', '>=', '<>', '!=','like', 'not like', 'is in', 'is not in'.
	*  when the 'operator' is 'like' the 'data' already contains the '%' character in the appropiate position.
	*  The 'data' key will contain the string searched by the user.
	* @return integer
	*  Total number of rows
	*/
	public function getTotalNumberOfRows(array $filters = array())
	{
		return 1;
	}

	/**
	* Get the rows data to be shown in the grid.
	*
	* @param  integer $limit
	*  Number of rows to be shown into the grid
	* @param  integer $offset
	*  Start position
	* @param  string $orderBy
	*  Column name to order by.
	* @param  array $sordvisibleColumns
	*  Sorting order
	* @param  array $filters
	*  An array of filters, example: array(array('field'=>'column index/name 1','op'=>'operator','data'=>'searched string column 1'), array('field'=>'column index/name 2','op'=>'operator','data'=>'searched string column 2'))
	*  The 'field' key will contain the 'index' column property if is set, otherwise the 'name' column property.
	*  The 'op' key will contain one of the following operators: '=', '<', '>', '<=', '>=', '<>', '!=','like', 'not like', 'is in', 'is not in'.
	*  when the 'operator' is 'like' the 'data' already contains the '%' character in the appropiate position.
	*  The 'data' key will contain the string searched by the user.
	* @return array
	*  An array of array, each array will have the data of a row.
	*  Example: array(array("column1" => "1-1", "column2" => "1-2"), array("column1" => "2-1", "column2" => "2-2"))
	*/
	public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(), $nodeId = null, $nodeLevel = null, $exporting)
	{
		$orderByRaw = null;

		if(!is_null($orderBy) || !is_null($sord))
		{
			$found = false;
			$pos = strpos($orderBy, 'desc');

			if ($pos !== false)
			{
				$found = true;
			}
			else
			{
				$pos = strpos($orderBy, 'asc');

				if ($pos !== false)
				{
					$found = true;
				}
			}

			if($found)
			{
				$orderBy = rtrim($orderBy);

				if(substr($orderBy, -1) == ',')
				{
					$orderBy = substr($orderBy, 0, -1);
				}
				else
				{
					$orderBy .= " $sord";
				}

				$orderByRaw = $orderBy;
			}
			else
			{
				$this->orderBy = array(array($orderBy, $sord));
			}
		}

		if($limit == 0)
		{
			$limit = 1;
		}

		if(empty($orderByRaw))
		{
			$orderByRaw = array();

			foreach ($this->orderBy as $orderBy)
			{
				array_push($orderByRaw, implode(' ',$orderBy));
			}

			$orderByRaw = implode(',',$orderByRaw);
		}

		$query = $this->Database->whereNested(function($query) use ($filters)
		{
			foreach ($filters as $filter)
			{
				if($filter['op'] == 'is in')
				{
					$query->whereIn($filter['field'], explode(',',$filter['data']));
					continue;
				}

				if($filter['op'] == 'is not in')
				{
					$query->whereNotIn($filter['field'], explode(',',$filter['data']));
					continue;
				}

				$query->where($filter['field'], $filter['op'], $filter['data']);
			}
		})
		->orderByRaw($orderByRaw)
		->union($this->Database3)
		->groupBy('c.id', 'c.parent_account_id', 'c.key', 'c.name', 'c.is_group', 'c.balance_type')
		->select($this->visibleColumns);

		$querySql = $query->toSql();

		$rows = $this->DB->connection($this->AuthenticationManager->getCurrentUserOrganizationConnection())
										->select($querySql . ' ORDER BY ' . $orderByRaw, $query->getBindings());

		$Income = $this->Database2->whereNested(function($query) use ($filters)
		{
			foreach ($filters as $filter)
			{
				if($filter['op'] == 'is in')
				{
					$query->whereIn($filter['field'], explode(',',$filter['data']));
					continue;
				}

				if($filter['op'] == 'is not in')
				{
					$query->whereNotIn($filter['field'], explode(',',$filter['data']));
					continue;
				}

				$query->where($filter['field'], $filter['op'], $filter['data']);
			}
		})
		->select(array($this->DB->raw('IFNULL(SUM(je.credit),0) - IFNULL(SUM(je.debit),0) AS result')))
		->first();

		$Expenses = $this->Database4->whereNested(function($query) use ($filters)
		{
			foreach ($filters as $filter)
			{
				if($filter['op'] == 'is in')
				{
					$query->whereIn($filter['field'], explode(',',$filter['data']));
					continue;
				}

				if($filter['op'] == 'is not in')
				{
					$query->whereNotIn($filter['field'], explode(',',$filter['data']));
					continue;
				}

				$query->where($filter['field'], $filter['op'], $filter['data']);
			}
		})
		->select(array($this->DB->raw('IFNULL(SUM(je.debit),0) - IFNULL(SUM(je.credit),0) AS result')))
		->first();

		if(!is_array($rows))
		{
			$rows = $rows->toArray();
		}

		foreach ($rows as &$row)
		{
			$row = (array) $row;
		}

		$newRows = account_balance_update($rows, 'acct_bs_', false, $Income->result - $Expenses->result);

		return $newRows;

	}

}

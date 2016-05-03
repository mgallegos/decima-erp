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

use Carbon\Carbon;

use Illuminate\Database\DatabaseManager as DatabaseManager;

use Illuminate\Translation\Translator;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class EloquentTrialBalanceGridRepository extends EloquentRepositoryAbstract {

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager, Translator $Lang, Carbon $Carbon)
	{
		$this->DB = $DB;

		$this->Carbon = $Carbon;

		$this->Database = $DB->table('ACCT_Journal_Entry AS je')
								->join('ACCT_Journal_Voucher AS jv', 'jv.id', '=', 'je.journal_voucher_id')
								->join('ACCT_Account AS c', 'je.account_id', '=', 'c.id')
								->where('jv.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->where('c.is_group', '=', 0)
								->whereNull('je.deleted_at')
								->whereNull('jv.deleted_at')
								->select(array($DB->raw('IFNULL(SUM(je.debit),0) AS acct_tb_debit'), $DB->raw('IFNULL(SUM(je.credit),0) AS acct_tb_credit'),
												'c.id AS acct_tb_account_id', 'c.parent_account_id AS acct_tb_parent_account_id','c.key AS acct_tb_account_key', 'c.name AS acct_tb_account_name', 'c.is_group AS acct_tb_is_group', 'c.balance_type AS acct_tb_balance_type',
												$DB->raw('0 AS acct_tb_total_debit'), $DB->raw('0 AS acct_tb_total_credit'), $DB->raw('0 AS acct_tb_opening_balance'), $DB->raw('0 AS acct_tb_closing_balance')
												)
								);

		$this->Database2 = $DB->table('ACCT_Account AS c')
								->where('c.is_group', '=', 1)
								->where('c.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->select(array($DB->raw('0 AS acct_tb_debit'), $DB->raw('0 AS acct_tb_credit'),
												'c.id AS acct_tb_account_id', 'c.parent_account_id AS acct_tb_parent_account_id','c.key AS acct_tb_account_key', 'c.name AS acct_tb_account_name', 'c.is_group AS acct_tb_is_group', 'c.balance_type AS acct_tb_balance_type',
												// $DB->raw('0 AS acct_tb_balance'),
												$DB->raw('0 AS acct_tb_total_debit'), $DB->raw('0 AS acct_tb_total_credit'), $DB->raw('0 AS acct_tb_opening_balance'), $DB->raw('0 AS acct_tb_closing_balance'),
												)
								);

		$this->Database3 = $DB->table('ACCT_Journal_Entry AS je')
								->join('ACCT_Journal_Voucher AS jv', 'jv.id', '=', 'je.journal_voucher_id')
								->join('ACCT_Account AS c', 'je.account_id', '=', 'c.id')
								->where('jv.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->where('c.is_group', '=', 0)
								->whereNull('je.deleted_at')
								->whereNull('jv.deleted_at')
								->select(array($DB->raw('0 AS acct_tb_debit'), $DB->raw('0 AS acct_tb_credit'),
												'c.id AS acct_tb_account_id', 'c.parent_account_id AS acct_tb_parent_account_id','c.key AS acct_tb_account_key', 'c.name AS acct_tb_account_name', 'c.is_group AS acct_tb_is_group', 'c.balance_type AS acct_tb_balance_type',
												$DB->raw('IFNULL(SUM(je.debit),0) acct_tb_total_debit'), $DB->raw('IFNULL(SUM(je.credit),0) AS acct_tb_total_credit'), $DB->raw('0 AS acct_tb_opening_balance'), $DB->raw('0 AS acct_tb_closing_balance')
												)
								);

		// $this->visibleColumns = array($DB->raw('IFNULL(SUM(je.debit),0) AS acct_tb_debit'), $DB->raw('IFNULL(SUM(je.credit),0) AS acct_tb_credit'),
		// 															'c.id AS acct_tb_account_id', 'c.parent_account_id AS acct_tb_parent_account_id','c.key AS acct_tb_account_key', 'c.name AS acct_tb_account_name', 'c.is_group AS acct_tb_is_group', 'c.balance_type AS acct_tb_balance_type',
		// 															$DB->raw('0 AS acct_tb_total_debit'), $DB->raw('0 AS acct_tb_total_credit'), $DB->raw('0 AS acct_tb_opening_balance'), $DB->raw('0 AS acct_tb_closing_balance'),
		// );

		$this->orderBy = array(array('acct_tb_account_key', 'asc'));
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

		$query2 = $this->Database3->whereNested(function($query) use ($filters)
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

				if($filter['field'] == 'jv.date' && $filter['op'] == '<=')
				{
					continue;
				}

				if($filter['field'] == 'auxiliary')
				{
					continue;
				}

				if($filter['field'] == 'jv.date' && $filter['op'] == '>=')
				{
					$query->where($filter['field'], '<', $filter['data']);
					$Date = new Carbon('first day of January ' . $this->Carbon->createFromFormat('Y-m-d', $filter['data'])->year);
					$query->where($filter['field'], '>=', $Date->format('Y-m-d'));
				}
				else
				{
					$query->where($filter['field'], $filter['op'], $filter['data']);
				}
			}
		})
		->groupBy('c.id', 'c.parent_account_id', 'c.key', 'c.name', 'c.is_group', 'c.balance_type');

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
		->union($this->Database2)
		->union($query2)
		->groupBy('c.id', 'c.parent_account_id', 'c.key', 'c.name', 'c.is_group', 'c.balance_type');

		$querySql = $query->toSql();

		$groupBy = "acct_tb_opening_balance, acct_tb_closing_balance, acct_tb_account_id, acct_tb_parent_account_id, acct_tb_account_key, acct_tb_account_name, acct_tb_is_group, acct_tb_balance_type";
		$select = "SUM(acct_tb_debit) AS acct_tb_debit, SUM(acct_tb_credit) AS acct_tb_credit, SUM(acct_tb_total_debit) AS acct_tb_total_debit, SUM(acct_tb_total_credit) AS acct_tb_total_credit, $groupBy";

		$rows = $this->DB->select("SELECT $select FROM ($querySql) AS A GROUP BY $groupBy ORDER BY $orderByRaw", $query->getBindings());

		if(!is_array($rows))
		{
			$rows = $rows->toArray();
		}

		foreach ($rows as &$row)
		{
			$row = (array) $row;
		}

		$newRows = account_balance_update($rows, 'acct_tb_');

		return $newRows;

	}

}

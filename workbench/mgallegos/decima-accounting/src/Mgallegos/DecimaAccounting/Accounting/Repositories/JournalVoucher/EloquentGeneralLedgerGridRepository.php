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

use Mgallegos\DecimaAccounting\Accounting\Services\AccountManagement\AccountManagementInterface;

use Carbon\Carbon;

use Illuminate\Database\DatabaseManager as DatabaseManager;

use Illuminate\Translation\Translator;

use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class EloquentGeneralLedgerGridRepository extends EloquentRepositoryAbstract {

	public function __construct(DatabaseManager $DB, AuthenticationManagementInterface $AuthenticationManager,AccountManagementInterface $AccountManager, Translator $Lang, Carbon $Carbon)
	{
		$this->DB = $DB;

		$this->AccountManager = $AccountManager;

		$this->AuthenticationManager = $AuthenticationManager;

		$this->Carbon = $Carbon;

		$this->Database = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Journal_Entry AS je')
								->join('ACCT_Journal_Voucher AS jv', 'jv.id', '=', 'je.journal_voucher_id')
								->join('ACCT_Account AS c', 'je.account_id', '=', 'c.id')
								->where('jv.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->where('c.is_group', '=', 0)
								->whereNull('je.deleted_at')
								->whereNull('jv.deleted_at')
								->select(array($DB->raw('IFNULL(SUM(je.debit),0) AS acct_gl_debit'), $DB->raw('IFNULL(SUM(je.credit),0) AS acct_gl_credit'),
												'c.id AS acct_gl_account_id', 'c.parent_account_id AS acct_gl_parent_account_id','c.key AS acct_gl_account_key', 'c.name AS acct_gl_account_name', 'c.is_group AS acct_gl_is_group', 'c.balance_type AS acct_gl_balance_type',
												$DB->raw('0 AS acct_gl_total_debit'), $DB->raw('0 AS acct_gl_total_credit'), $DB->raw('0 AS acct_gl_opening_balance'), $DB->raw('0 AS acct_gl_closing_balance'),
												$DB->raw('\'\' AS acct_gl_voucher_date'), $DB->raw('\'\' AS acct_gl_voucher_type'), $DB->raw('\'\' AS acct_gl_voucher_number'),
												)
								);

		$this->Database2 = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Account AS c')
								->where('c.is_group', '=', 1)
								->where('c.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->select(array($DB->raw('0 AS acct_gl_debit'), $DB->raw('0 AS acct_gl_credit'),
												'c.id AS acct_gl_account_id', 'c.parent_account_id AS acct_gl_parent_account_id','c.key AS acct_gl_account_key', 'c.name AS acct_gl_account_name', 'c.is_group AS acct_gl_is_group', 'c.balance_type AS acct_gl_balance_type',
												$DB->raw('0 AS acct_gl_total_debit'), $DB->raw('0 AS acct_gl_total_credit'), $DB->raw('0 AS acct_gl_opening_balance'), $DB->raw('0 AS acct_gl_closing_balance'),
												$DB->raw('\'\' AS acct_gl_voucher_date'), $DB->raw('\'\' AS acct_gl_voucher_type'), $DB->raw('\'\' AS acct_gl_voucher_number'),
												)
								);

		$this->Database3 = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Journal_Entry AS je')
								->join('ACCT_Journal_Voucher AS jv', 'jv.id', '=', 'je.journal_voucher_id')
								->join('ACCT_Account AS c', 'je.account_id', '=', 'c.id')
								->where('jv.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->where('c.is_group', '=', 0)
								->whereNull('je.deleted_at')
								->whereNull('jv.deleted_at')
								->select(array($DB->raw('0 AS acct_gl_debit'), $DB->raw('0 AS acct_gl_credit'),
												'c.id AS acct_gl_account_id', 'c.parent_account_id AS acct_gl_parent_account_id','c.key AS acct_gl_account_key', 'c.name AS acct_gl_account_name', 'c.is_group AS acct_gl_is_group', 'c.balance_type AS acct_gl_balance_type',
												$DB->raw('IFNULL(SUM(je.debit),0) AS acct_gl_total_credit'), $DB->raw('IFNULL(SUM(je.credit),0) AS acct_gl_total_credit'), $DB->raw('0 AS acct_gl_opening_balance'), $DB->raw('0 AS acct_gl_closing_balance'),
												$DB->raw('\'\' AS acct_gl_voucher_date'), $DB->raw('\'\' AS acct_gl_voucher_type'), $DB->raw('\'\' AS acct_gl_voucher_number'),
												)
								);

		$this->Database4 = $DB->connection($AuthenticationManager->getCurrentUserOrganizationConnection())
								->table('ACCT_Journal_Entry AS je')
								->join('ACCT_Journal_Voucher AS jv', 'jv.id', '=', 'je.journal_voucher_id')
								->join('ACCT_Voucher_Type AS vt', 'vt.id', '=', 'jv.voucher_type_id')
								->join('ACCT_Account AS c', 'je.account_id', '=', 'c.id')
								->where('jv.organization_id', '=', $AuthenticationManager->getCurrentUserOrganizationId())
								->where('c.is_group', '=', 0)
								->whereNull('je.deleted_at')
								->whereNull('jv.deleted_at')
								->select(array($DB->raw('je.debit AS acct_gl_debit'), $DB->raw('je.credit AS acct_gl_credit'),
												'c.id AS acct_gl_account_id', 'c.parent_account_id AS acct_gl_parent_account_id',$DB->raw('IFNULL(jv.manual_reference,"' . $Lang->get('decima-accounting::journal-management.noRef') . '") AS acct_gl_account_key'), 'jv.remark AS acct_gl_account_name', 'c.is_group AS acct_gl_is_group', 'c.balance_type AS acct_gl_balance_type',
												$DB->raw('0 AS acct_gl_total_debit'), $DB->raw('0 AS acct_gl_total_credit'),$DB->raw('0 AS acct_gl_opening_balance'), $DB->raw('0 AS acct_gl_closing_balance'),
												$DB->raw('DATE_FORMAT(jv.date, "' . $Lang->get('form.mysqlDateFormat') . '") AS acct_gl_voucher_date'), $DB->raw('vt.name AS acct_gl_voucher_type'), $DB->raw('jv.number AS acct_gl_voucher_number'),
												)
								);

		$this->orderBy = array(array('acct_gl_account_key', 'asc'));
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

		$accountChildrenIds = array();

		$query3 = $this->Database3->whereNested(function($query) use ($filters, &$accountChildrenIds)
		{
			foreach ($filters as $filter)
			{
				if($filter['field'] == 'je.account_id')
				{
					$accountChildrenIds = $this->AccountManager->getAccountChildrenIds($filter['data']);
					array_push($accountChildrenIds, $filter['data']);
					$query->whereIn($filter['field'], $accountChildrenIds);
					continue;
				}

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

		// var_dump($accountChildrenIds);die();
		// var_dump($query3->toSql(), $query3->getBindings());die();

		$query = $this->Database->whereNested(function($query) use ($filters, &$auxiliary, $accountChildrenIds)
		{
			foreach ($filters as $filter)
			{
				if($filter['field'] == 'je.account_id')
				{
					$query->whereIn($filter['field'], $accountChildrenIds);
					continue;
				}

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

				if($filter['field'] == 'auxiliary')
				{
					$auxiliary = $filter['data'];
					continue;
				}

				$query->where($filter['field'], $filter['op'], $filter['data']);
			}
		})
		->union($this->Database2)
		->union($query3)
		->groupBy('c.id', 'c.parent_account_id', 'c.key', 'c.name', 'c.is_group', 'c.balance_type');

		// var_dump($query->get());die();
		// var_dump($query->toSql(), $query->getBindings());die();

		$querySql = $query->toSql();

		$groupBy = "acct_gl_voucher_date, acct_gl_voucher_type, acct_gl_voucher_number, acct_gl_opening_balance, acct_gl_closing_balance, acct_gl_account_id, acct_gl_parent_account_id, acct_gl_account_key, acct_gl_account_name, acct_gl_is_group, acct_gl_balance_type";
		$select = "SUM(acct_gl_debit) AS acct_gl_debit, SUM(acct_gl_credit) AS acct_gl_credit, SUM(acct_gl_total_debit) AS acct_gl_total_debit, SUM(acct_gl_total_credit) AS acct_gl_total_credit, $groupBy";

		// var_dump("SELECT $select FROM ($querySql) AS A GROUP BY $groupBy ORDER BY $orderByRaw");

		$rows = $this->DB->connection($this->AuthenticationManager->getCurrentUserOrganizationConnection())
								->select("SELECT $select FROM ($querySql) AS A GROUP BY $groupBy ORDER BY $orderByRaw", $query->getBindings());

		if(!is_array($rows))
		{
			$rows = $rows->toArray();
		}

		foreach ($rows as &$row)
		{
			$row = (array) $row;
		}

		if(!empty($auxiliary))
		{
			$detailRows = $this->Database4->whereNested(function($query) use ($filters, $accountChildrenIds)
			{
				foreach ($filters as $filter)
				{
					if($filter['field'] == 'je.account_id')
					{
						$query->whereIn($filter['field'], $accountChildrenIds);
						continue;
					}

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

					if($filter['field'] == 'auxiliary')
					{
						continue;
					}

					$query->where($filter['field'], $filter['op'], $filter['data']);
				}
			})
			->orderByRaw('jv.date')
			->get();

			if(!is_array($detailRows))
			{
				$detailRows = $detailRows->toArray();
			}
		}

		// var_dump($rows);die();
		// var_dump($detailRows);die();

		$headerRows = account_balance_update($rows, 'acct_gl_');

		// var_dump($headerRows);die();

		$newRows = array();

		if(empty($auxiliary))
		{
			if(count($accountChildrenIds) > 0)
			{
				foreach ($headerRows as $headerRowKey => $headerRow)
				{
					if(in_array($headerRow['acct_gl_account_id'], $accountChildrenIds))
					{
						array_push($newRows, $headerRow);
					}
				}

				return $newRows;
			}
			else
			{
				return $headerRows;
			}
		}

		foreach ($headerRows as $headerRowKey => $headerRow)
		{
			if(count($accountChildrenIds) > 0)
			{
				if(in_array($headerRow['acct_gl_account_id'], $accountChildrenIds))
				{
					array_push($newRows, $headerRow);
				}
			}
			else
			{
				array_push($newRows, $headerRow);
			}

			if(empty($headerRow['acct_gl_is_group']))
			{
				$count = 0;

				foreach ($detailRows as $keyDetailRow => $detailRow)
				{
					if($detailRow->acct_gl_account_id == $headerRow['acct_gl_account_id'])
					{
						$count++;

						if($count == 1)
						{
							$detailRow->acct_gl_opening_balance = $headerRow['acct_gl_opening_balance'];
						}
						else
						{
							$detailRow->acct_gl_opening_balance = $closingBalance;
						}

						if($detailRow->acct_gl_balance_type == 'D')
						{
							$detailRow->acct_gl_closing_balance = $detailRow->acct_gl_opening_balance + $detailRow->acct_gl_debit - $detailRow->acct_gl_credit;
						}
						else
						{
							$detailRow->acct_gl_closing_balance = $detailRow->acct_gl_opening_balance - $detailRow->acct_gl_debit + $detailRow->acct_gl_credit;
						}

						$closingBalance = $detailRow->acct_gl_closing_balance;

						array_push($newRows, (array) $detailRow);
					}
				}
			}
		}

		return $newRows;
	}

}

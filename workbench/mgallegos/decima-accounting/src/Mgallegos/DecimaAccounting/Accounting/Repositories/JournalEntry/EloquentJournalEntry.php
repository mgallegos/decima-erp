<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\DatabaseManager;

class EloquentJournalEntry implements JournalEntryInterface {

  /**
   * JournalEntry
   *
   * @var Mgallegos\DecimaAccounting\Accounting\JournalEntry
   *
   */
  protected $JournalEntry;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $JournalEntry, DatabaseManager $DB, $databaseConnectionName)
  {
      $this->JournalEntry = $JournalEntry;

      $this->DB = $DB;

      $this->databaseConnectionName = $databaseConnectionName;

      $this->JournalEntry->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->JournalEntry->getTable();
  }


  /**
   * Get set of journal vouchers by ID
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\JournalEntry
   */
  public function byId($id)
  {
  	return $this->JournalEntry->on($this->databaseConnectionName)->find($id);
  }

  /**
   * Get the debit sum of all entries of a journal voucher
   *
   * @param  int $id Journal Voucher id
   *
   * @return integer
   */
  public function byJournalVoucherId($id)
  {
    return $this->JournalEntry->where('journal_voucher_id', '=', $id)->get();
  }

  /**
   * Get journal entries by account ids
   *
   * @param  int $id Journal Voucher id
   *
   * @return integer
   */
  public function byAccountIds($ids)
  {
    return $this->JournalEntry->whereIn('account_id', $ids)->get();
  }

  /**
   * Get journal entries by cost center ids
   *
   * @param  int $id Journal Voucher id
   *
   * @return integer
   */
  public function byCostCenterIds($ids)
  {
    return $this->JournalEntry->whereIn('cost_center_id', $ids)->get();
  }

  /**
   * Get the debit sum of all entries of a journal voucher
   *
   * @param  int $id Journal Voucher id
   *
   * @return integer
   */
  public function getJournalVoucherDebitSum($id)
  {
    return $this->JournalEntry->where('journal_voucher_id', '=', $id)->sum('debit');
  }

  /**
   * Get the credit sum of all entries of a journal voucher
   *
   * @param  int $id Journal Voucher id
   *
   * @return array of stdClass
   */
  public function getJournalEntriesGroupedByPlBsCategoryByOrganizationAndByFiscalYear($plBsCategory, $organizationId, $fiscalYearId)
  {
    // $this->DB->connection()->enableQueryLog();

    // $Entries = $this->DB->table('ACCT_Journal_Entry AS je')
    //     				->join('ACCT_Journal_Voucher AS jv', 'jv.id', '=', 'je.journal_voucher_id')
    //     				->join('ACCT_Period AS p', 'p.id', '=', 'jv.period_id')
    //             ->join('ACCT_Account AS c', 'je.account_id', '=', 'c.id')
    //     				->join('ACCT_Account_Type AS at', 'at.id', '=', 'c.account_type_id')
    //     				->where('jv.status', '=', 'B')
    //     				->where('jv.organization_id', '=', $organizationId)
    //     				->where('p.fiscal_year_id', '=', $fiscalYearId)
    //     				// ->where('c.is_group', '=', 0)
    //     				->where('at.pl_bs_category', '=', $plBsCategory)
    //     				->whereNull('je.deleted_at')
    //     				->whereNull('jv.deleted_at')
    //             // ->groupBy('journal_voucher_id', 'je.cost_center_id', 'je.account_id')
    //             ->groupBy('journal_voucher_id', 'je.cost_center_id', 'je.account_id')
    //             ->select(array($this->DB->raw('SUM(je.debit) as debit'), $this->DB->raw('SUM(je.credit) as credit'),
    //                     //  $this->DB->raw("$journalVoucherId AS journal_voucher_id"), 'je.cost_center_id', 'je.account_id'
    //                      $this->DB->raw("$journalVoucherId AS journal_voucher_id"), 'je.cost_center_id', 'je.account_id'
    //                   )
    //                   )->get();

    return $this->DB->connection($this->databaseConnectionName)
            ->table('ACCT_Journal_Entry AS je')
        		->join('ACCT_Journal_Voucher AS jv', 'jv.id', '=', 'je.journal_voucher_id')
            ->join('ACCT_Account AS c', 'c.id', '=', 'je.account_id')
            ->join('ACCT_Period AS p', 'p.id', '=', 'jv.period_id')
            ->join('ACCT_Account_Type AS at', 'at.id', '=', 'c.account_type_id')
        		->where('jv.organization_id', '=', $organizationId)
            ->where('p.fiscal_year_id', '=', $fiscalYearId)
            ->where('jv.status', '=', 'B')
            ->whereIn('at.pl_bs_category', $plBsCategory)
            ->whereNull('je.deleted_at')
            ->whereNull('jv.deleted_at')
            ->groupBy('je.cost_center_id', 'je.account_id', 'c.balance_type')
            ->select(array($this->DB->raw('SUM(je.debit) as debit'), $this->DB->raw('SUM(je.credit) as credit'), 'je.cost_center_id', 'je.account_id', 'c.balance_type'))
            ->get();

    // var_dump($this->DB->getQueryLog(), $Entries);die();
  }

  /**
   * Get the credit sum of all entries of a journal voucher
   *
   * @param  int $id Journal Voucher id
   *
   * @return integer
   */
  public function getJournalVoucherCreditSum($id)
  {
    return $this->JournalEntry->where('journal_voucher_id', '=', $id)->sum('credit');
  }


  /**
   * Create a new set of journal vouchers
   *
   * @param array $data
   * 	An array as follows: array('debit'=>$debit, 'credit'=>$credit, 'system_reference_type'=>$systemReferenceType, 'system_reference_field'=>$systemReferenceField,
   *                             'journal_voucher_id'=>journalVoucherId, 'cost_center_id'=>$costCenterId, 'account_id' => $accountId
   *                            );
   *
   * @return Mgallegos\DecimaAccounting\JournalEntry
   */
  public function create(array $data)
  {
    $this->JournalEntry->fill($data)->save();

    return $this->JournalEntry;
  }

  /**
   * Create a new set of journal vouchers
   *
   * @param array of array
   * 	Each array as follows: array('debit'=>$debit, 'credit'=>$credit, 'system_reference_type'=>$systemReferenceType, 'system_reference_field'=>$systemReferenceField,
   *                             'journal_voucher_id'=>journalVoucherId, 'cost_center_id'=>$costCenterId, 'account_id' => $accountId
   *                            );
   *
   * @return void
   */
  public function massCreate(array $data)
  {
    $this->DB->connection($this->databaseConnectionName)->table('ACCT_Journal_Entry')->insert($data);
  }

  /**
   * Update an existing set of journal vouchers
   *
   * @param array $data
   * 	An array as follows: array('debit'=>$debit, 'credit'=>$credit, 'system_reference_type'=>$systemReferenceType, 'system_reference_field'=>$systemReferenceField,
   *                             'journal_voucher_id'=>journalVoucherId, 'cost_center_id'=>$costCenterId, 'account_id' => $accountId
   *                            );
   *
   * @param Mgallegos\DecimaAccounting\JournalEntry $JournalEntry
   *
   * @return Mgallegos\DecimaAccounting\JournalEntry
   */
  public function update(array $data, $JournalEntry = null)
  {
    if(empty($JournalEntry))
    {
      $JournalEntry = $this->byId($data['id']);
    }

    foreach ($data as $key => $value)
    {
      $JournalEntry->$key = $value;
    }

    $JournalEntry->save();

    return $JournalEntry;
  }

  /**
   * Delete existing journal entries (soft delete)
   *
   * @param array $ids
   * 	An array as follows: array($id0, $id1,…);
   * @return boolean
   */
  public function delete(array $ids)
  {
    $this->JournalEntry->destroy($ids);

    return true;
  }
}

<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher;

use Illuminate\Database\Eloquent\Model;

use Mgallegos\DecimaAccounting\Accounting\JournalVoucher;

class EloquentJournalVoucher implements JournalVoucherInterface {

  /**
   * JournalVoucher
   *
   * @var Mgallegos\DecimaAccounting\Accounting\JournalVoucher
   *
   */
  protected $JournalVoucher;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $JournalVoucher, $databaseConnectionName)
  {
      $this->JournalVoucher = $JournalVoucher;

      $this->databaseConnectionName = $databaseConnectionName;

      $this->JournalVoucher->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->JournalVoucher->getTable();
  }


  /**
   * Get set of journal vouchers by ID
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\JournalVoucher
   */
  public function byId($id)
  {
  	return $this->JournalVoucher->on($this->databaseConnectionName)->find($id);
  }

  /**
   * Get the max journal voucher number
   *
   * @param  int $id Organization id
   *
   * @return integer
   */
  public function getMaxJournalVoucherNumber($id)
  {
    return $this->JournalVoucher->where('organization_id', '=', $id)->max('number');
  }

  /**
   * Get the max journal voucher number by period
   *
   * @param  int $organizationId
   * @param  int $periodId
   *
   * @return integer
   */
  public function getMaxJournalVoucherNumberByPeriod($organizationId, $periodId)
  {
    return $this->JournalVoucher->where('organization_id', '=', $organizationId)->where('period_id', '=', $periodId)->max('number');
  }

  /**
   * Get the max journal voucher number by period
   *
   * @param  int $organizationId
   * @param  int $periodId
   * @param  int $voucherTypeId
   *
   * @return integer
   */
  public function getMaxJournalVoucherNumberByPeriodAndAccountType($organizationId, $periodId, $voucherTypeId)
  {
    return $this->JournalVoucher->where('organization_id', '=', $organizationId)->where('period_id', '=', $periodId)->where('voucher_type_id', '=', $voucherTypeId)->max('number');
  }

  /**
   * Get journal voucher by organization, by period and by status
   *
   * @param  int $organizationId
   * @param  array $periodIds
   * @param  string $status
   *
   * @return integer
   */
  public function getByOrganizationByPeriodAndByStatus($organizationId, $periodIds, $status)
  {
    return $this->JournalVoucher->where('organization_id', '=', $organizationId)
            ->whereIn('period_id', $periodIds)
            ->where('status', '=', $status)
            ->get();
  }


  /**
   * Create a new set of journal vouchers
   *
   * @param array $data
   * 	An array as follows: array('number'=>$number, 'date'=>$date, 'manual_reference'=>$manualReference, 'remark'=>$remark,
   *                              'system_reference_type'=>$systemTeferenceType, 'system_reference_field'=>$systemReferenceField, 'system_reference_id'=>$systemReferenceId
   *                              'is_editable'=>$isEditable, 'status'=>$status, 'voucher_type_id'=>$voucherTypeId, 'created_by'=>$created_by, 'organization_id'=>organizationId
   *                            );
   *
   * @return Mgallegos\DecimaAccounting\JournalVoucher
   */
  public function create(array $data)
  {
    $JournalVoucher = new JournalVoucher();

    $JournalVoucher->setConnection($this->databaseConnectionName);

    $JournalVoucher->fill($data)->save();

    return $JournalVoucher;
  }

  /**
   * Update an existing set of journal vouchers
   *
   * @param array $data
   * 	An array as follows: array('number'=>$number, 'date'=>$date, 'manual_reference'=>$manualReference, 'remark'=>$remark,
   *                              'system_reference_type'=>$systemTeferenceType, 'system_reference_field'=>$systemReferenceField, 'system_reference_id'=>$systemReferenceId
   *                              'is_editable'=>$isEditable, 'status'=>$status, 'voucher_type_id'=>$voucherTypeId, 'created_by'=>$created_by, 'organization_id'=>organizationId
   *                            );
   *
   * @param Mgallegos\DecimaAccounting\JournalVoucher $JournalVoucher
   *
   * @return Mgallegos\DecimaAccounting\JournalVoucher
   */
  public function update(array $data, $JournalVoucher = null)
  {
    if(empty($JournalVoucher))
    {
      $JournalVoucher = $this->byId($data['id']);
    }

    foreach ($data as $key => $value)
    {
      $JournalVoucher->$key = $value;
    }

    $JournalVoucher->save();

    return $JournalVoucher;
  }

  /**
   * Delete existing journal vouchers (soft delete)
   *
   * @param array $ids
   * 	An array as follows: array($id0, $id1,…);
   * @return boolean
   */
  public function delete(array $ids)
  {
    $this->JournalVoucher->destroy($ids);

    return true;
  }
}

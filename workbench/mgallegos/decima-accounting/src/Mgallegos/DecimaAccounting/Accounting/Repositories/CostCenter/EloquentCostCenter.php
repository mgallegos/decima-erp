<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter;

use Illuminate\Database\Eloquent\Model;

use Mgallegos\DecimaAccounting\Accounting\CostCenter;

class EloquentCostCenter implements CostCenterInterface {

  /**
   * CostCenter
   *
   * @var Mgallegos\DecimaAccounting\Accounting\CostCenter
   *
   */
  protected $CostCenter;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $CostCenter, $databaseConnectionName)
  {
      $this->CostCenter = $CostCenter;

      $this->databaseConnectionName = $databaseConnectionName;

      $this->CostCenter->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->CostCenter->getTable();
  }

  /**
   * Get an account by ID
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\CostCenter
   */
  public function byId($id)
  {
  	return $this->CostCenter->on($this->databaseConnectionName)->find($id);
  }

  /**
   * Get an cost centers by ID's
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\CostCenter
   */
  public function byIds(array $ids)
  {
  	return $this->CostCenter->whereIn('id',$ids)->get();
  }

  /**
   * Retrieve cost centers by organization
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganization($id)
  {
    return $this->CostCenter->where('organization_id', '=', $id)->get();
  }

  /**
   * Retrieve cost centers by organization and by key
   *
   * @param  int $organizationId
   * @param  string $key
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganizationAndByKey($organizationId, $key)
  {
    return $this->CostCenter->where('organization_id', '=', $organizationId)->where('key', '=', $key)->get();
  }

  /**
   * Retrieve cost centers by parent
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byParent($id)
  {
    return $this->CostCenter->where('parent_cc_id', '=', $id)->get();
  }

  /**
   * Create a new cost center
   *
   * @param array $data
   * 	An array as follows: array('name'=>$name, 'key'=>$key, 'parent_cc_id' => $parentCostCenterId, 'organization_id'=>$organizationId, 'is_group'=> $isGroup);
   *
   * @return boolean
   */
  public function create(array $data)
  {
    $CostCenter = new CostCenter();
    $CostCenter->setConnection($this->databaseConnectionName);
    $CostCenter->fill($data)->save();

    return $CostCenter;
  }

  /**
   * Update an existing cost center
   *
   * @param array $data
   * 	An array as follows: array('name'=>$name, 'key'=>$key, 'parent_cc_id' => $parentCostCenterId, 'organization_id'=>$organizationId, 'is_group'=> $isGroup);
   *
   * @param Mgallegos\DecimaAccounting\CostCenter $CostCenter
   *
   * @return boolean
   */
  public function update(array $data, $CostCenter = null)
  {
    if(empty($CostCenter))
    {
      $CostCenter = $this->byId($data['id']);
    }

    foreach ($data as $key => $value)
    {
      $CostCenter->$key = $value;
    }

    return $CostCenter->save();
  }

  /**
   * Delete existing cost center (soft delete)
   *
   * @param array $data
   * 	An array as follows: array($id0, $id1,…);
   * @return boolean
   */
  public function delete(array $data)
  {
    foreach ($data as $key => $id)
    {
      $CostCenter = $this->byId($id);
      $CostCenter->delete();
    }
    // $this->CostCenter->destroy($data);

    return true;
  }

}

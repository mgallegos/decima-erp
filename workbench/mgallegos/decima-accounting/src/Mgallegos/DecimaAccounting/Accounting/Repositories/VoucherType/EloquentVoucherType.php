<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Repositories\VoucherType;

use Illuminate\Database\Eloquent\Model;

use Mgallegos\DecimaAccounting\Accounting\VoucherType;

class EloquentVoucherType implements VoucherTypeInterface {

  /**
   * VoucherType
   *
   * @var Mgallegos\DecimaAccounting\Accounting\VoucherType
   *
   */
  protected $VoucherType;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $VoucherType, $databaseConnectionName)
  {
      $this->VoucherType = $VoucherType;

      $this->databaseConnectionName = $databaseConnectionName;

      $this->VoucherType->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->VoucherType->getTable();
  }


  /**
   * Get an Voucher type by ID
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\VoucherType
   */
  public function byId($id)
  {
  	return $this->VoucherType->on($this->databaseConnectionName)->find($id);
  }

  /**
   * Retrieve voucher types by organization
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganization($id)
  {
    return $this->VoucherType->where('organization_id', '=', $id)->get();
  }

  /**
   * Create a new Voucher type
   *
   * @param array $data
   * 	An array as follows: array('name'=>$name, 'lang_key'=>$langKey, 'organization_id' => $organizationId);
   *
   *
   * @return boolean
   */
  public function create(array $data)
  {
    $VoucherType = new VoucherType();
    $VoucherType->setConnection($this->databaseConnectionName);
    $VoucherType->fill($data)->save();

    return $VoucherType;
  }

  /**
   * Update an existing Voucher type
   *
   * @param array $data
   * 	An array as follows: array('name'=>$name, 'lang_key'=>$langKey, 'organization_id' => $organizationId);
   *
   * @param Mgallegos\DecimaAccounting\VoucherType $VoucherType
   *
   * @return boolean
   */
  public function update(array $data, $VoucherType = null)
  {
    if(empty($VoucherType))
    {
      $VoucherType = $this->byId($data['id']);
    }

    foreach ($data as $key => $value)
    {
      $VoucherType->$key = $value;
    }

    return $VoucherType->save();
  }

}

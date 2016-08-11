<?php
/**
 * @file
 * Description of the script.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Vendor\DecimaModule\Module\Repositories\ModuleTableName;

use Illuminate\Database\Eloquent\Model;

use Vendor\DecimaModule\Module\ModuleTableName;

class EloquentModuleTableName implements ModuleTableNameInterface {

  /**
   * ModuleTableName
   *
   * @var Vendor\DecimaModule\Module\ModuleTableName;
   *
   */
  protected $ModuleTableName;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $ModuleTableName, $databaseConnectionName)
  {
      $this->ModuleTableName = $ModuleTableName;

      $this->databaseConnectionName = $databaseConnectionName;

      $this->ModuleTableName->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->ModuleTableName->getTable();
  }

  /**
   * Get a ... by ID
   *
   * @param  int $id
   *
   * @return Vendor\DecimaModule\Module\ModuleTableName
   */
  public function byId($id)
  {
  	return $this->ModuleTableName->on($this->databaseConnectionName)->find($id);
  }

  /**
   * Retrieve ... by organization
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganization($id)
  {
    return $this->ModuleTableName->where('organization_id', '=', $id)->get();
  }

  /**
   * Create a new ...
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1
   *                            );
   *
   * @return boolean
   */
  public function create(array $data)
  {
    $ModuleTableName = new ModuleTableName();
    $ModuleTableName->setConnection($this->databaseConnectionName);
    $ModuleTableName->fill($data)->save();

    return $ModuleTableName;
  }

  /**
   * Update an existing ...
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1
   *                            );
   *
   * @param Vendor\DecimaModule\Module\ModuleTableName $ModuleTableName
   *
   * @return boolean
   */
  public function update(array $data, $ModuleTableName = null)
  {
    if(empty($ModuleTableName))
    {
      $ModuleTableName = $this->byId($data['id']);
    }

    foreach ($data as $key => $value)
    {
      $ModuleTableName->$key = $value;
    }

    return $ModuleTableName->save();
  }

  /**
   * Delete existing ... (soft delete)
   *
   * @param array $data
   * 	An array as follows: array($id0, $id1,…);
   * @return boolean
   */
  public function delete(array $data)
  {
    foreach ($data as $key => $id)
    {
      $ModuleTableName = $this->byId($id);
      $ModuleTableName->delete();
    }
    // $this->Account->destroy($data);

    return true;
  }

}

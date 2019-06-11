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

use Illuminate\Database\DatabaseManager;

use Illuminate\Database\Eloquent\Collection;

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
   * DB
   *
   * @var Illuminate\Database\DatabaseManager
   *
   */
  protected $DB;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $ModuleTableName, DatabaseManager $DB, $databaseConnectionName)
  {
    $this->ModuleTableName = $ModuleTableName;

    $this->DB = $DB;

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
   * Get search modal table rows
   *
   * @param int $organizationId
   *
   * @return Collection
   */
  public function searchModalTableRows($id = null, $organizationId, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

    $query = $this->DB->connection($databaseConnectionName)
      ->table('Table_Name0 AS t0')
      ->join('Table_Name1 AS t1', 't1.column_name', '=', 't0.column_name')
      // ->where('p.id', '=', $ids)
      // ->orderBy('t1.column_name0', 'desc')
      // ->orderBy('t1.column_name1', 'asc')
      ->whereIn('t1.id', $ids);

    if(!empty($id))
    {
      $query->where('t0.id', '=', $id);
    }

    return new Collection(
      $query->get(
        array(
          't0.*'
        )
      )
    );
  }

  /**
   * Get a ... by ID
   *
   * @param  int $id
   *
   * @return Vendor\DecimaModule\Module\ModuleTableName
   */
  public function byId($id, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

  	return $this->ModuleTableName->on($databaseConnectionName)->find($id);
  }

  /**
   * Get a ... by ID
   *
   * @param  int $id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byIds($ids, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

    return new Collection(
      $this->DB->connection($databaseConnectionName)
        ->table('Table_Name0 AS t0')
        ->join('Table_Name1 AS t1', 't1.column_name', '=', 't0.column_name')
        // ->where('p.id', '=', $ids)
        ->whereIn('t1.id', $ids)
        // ->orderBy('t1.column_name0', 'desc')
        // ->orderBy('t1.column_name1', 'asc')
        ->get(array('t0.*'))
    );
  }

  /**
   * Retrieve ... by organization
   *
   * @param  int $id Organization id
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function byOrganization($id, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

    return $this->ModuleTableName->setConnection($databaseConnectionName)->where('organization_id', '=', $id)->get();
  }

  /**
   * Get max number
   *
   * @param  int $id Organization id
   *
   * @return integer
   */
  public function getMaxNumber($id, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

    return $this->ModuleTableName->setConnection($databaseConnectionName)
      ->where('organization_id', '=', $id)
      ->max('number');
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
  public function create(array $data, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

    $ModuleTableName = new ModuleTableName();
    $ModuleTableName->setConnection($databaseConnectionName);
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
  public function update(array $data, $ModuleTableName = null, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

    if(empty($ModuleTableName))
    {
      $ModuleTableName = $this->byId($data['id'], $databaseConnectionName);
    }

    foreach ($data as $key => $value)
    {
      $ModuleTableName->$key = $value;
    }

    return $ModuleTableName->save();
  }

  /**
   * Update by column name
   *
   * @param int $columnNameOldValue
   * @param integer $organizationId
   * @param string $databaseConnectionName
   *
   * @return boolean
   */
  public function updateByColumnName($columnNameOldValue, $organizationId, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

    $this->ModuleTableName->setConnection($databaseConnectionName)
      ->where('column_name', '=', $columnNameOldValue)
      ->where('organization_id', '=', $organizationId)
      ->update(array('column_name_to_be_updated' => $newValue));

    return true;
  }

  /**
   * Delete existing ... (soft delete)
   *
   * @param array $data
   * 	An array as follows: array($id0, $id1,…);
   * @return boolean
   */
  public function delete(array $data, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

    foreach ($data as $key => $id)
    {
      $ModuleTableName = $this->byId($id, $databaseConnectionName);
      $ModuleTableName->delete();
    }
    // $this->Account->destroy($data);

    return true;
  }

  /**
   * Mass detele
   *
   * @param integer $fileId
   *
   *
   * @return boolean
   */
  public function massDelete($id, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

    $this->DB->connection($databaseConnectionName)
      ->table($this->getTable())
      ->where('column_name', '=', $id)
      ->delete();

    return true;
  }

}

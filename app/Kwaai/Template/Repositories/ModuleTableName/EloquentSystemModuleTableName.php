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
   * @var Mgallegos\DecimaDashboard\Dashboard\ModuleTableName;
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

  public function __construct(Model $ModuleTableName, DatabaseManager $DB)
  {
    $this->ModuleTableName = $ModuleTableName;

    $this->DB = $DB;
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
    $query = $this->DB->table('Table_Name0 AS t0')
      ->join('Table_Name1 AS t1', 't1.column_name', '=', 't0.column_name')
      // ->orderBy('t1.column_name0', 'desc')
      // ->orderBy('t1.column_name1', 'asc')
      // ->whereIn('t1.id', $ids)
      ->where('t0.organization_id', '=', $organizationId);

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
   * @return Mgallegos\DecimaDashboard\Dashboard\ModuleTableName
   */
  public function byId($id, $databaseConnectionName = null)
  {
  	return $this->ModuleTableName->find($id);
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
    return new Collection(
      $this->DB->table('Table_Name0 AS t0')
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
    return $this->ModuleTableName->where('organization_id', '=', $id)->get();
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
    return $this->ModuleTableName->where('organization_id', '=', $id)
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
    $ModuleTableName = new ModuleTableName();
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
   * @param Mgallegos\DecimaDashboard\Dashboard\ModuleTableName $ModuleTableName
   *
   * @return boolean
   */
  public function update(array $data, $ModuleTableName = null, $databaseConnectionName = null)
  {
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
  public function updateByColumnNameEloquent($columnNameOldValue, $organizationId, $databaseConnectionName = null)
  {
    $this->ModuleTableName->where('column_name', '=', $columnNameOldValue)
      ->where('organization_id', '=', $organizationId)
      ->update(array('column_name_to_be_updated' => $newValue));

    return true;
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
  public function updateByColumnNameQueryBuilder($columnNameOldValue, $organizationId, $databaseConnectionName = null)
  {
    $this->DB->table($this->getTable())
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
    foreach ($data as $key => $id)
    {
      $ModuleTableName = $this->byId($id, $databaseConnectionName);
      $ModuleTableName->delete();
    }
    
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
    $this->DB->table($this->getTable())
      ->where('column_name', '=', $id)
      ->delete();

    return true;
  }

}

<?php
/**
 * @file
 * Description of the script.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Template\Repositories\ModuleTableName;

use Illuminate\Database\Eloquent\Model;

use App\Kwaai\Template\TableName;

class EloquentModuleTableName implements ModuleTableNameInterface {

  /**
   * Account
   *
   * @var App\Kwaai\Template\TableName;
   *
   */
  protected $TableName;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $TableName, $databaseConnectionName)
  {
      $this->Account = $TableName;

      $this->databaseConnectionName = $databaseConnectionName;

      $this->TableName->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->TableName->getTable();
  }

  /**
   * Get a ... by ID
   *
   * @param  int $id
   *
   * @return Mgallegos\DecimaAccounting\Account
   */
  public function byId($id)
  {
  	return $this->TableName->on($this->databaseConnectionName)->find($id);
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
    return $this->TableName->where('organization_id', '=', $id)->get();
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
    $TableName = new Account();
    $TableName->setConnection($this->databaseConnectionName);
    $TableName->fill($data)->save();

    return $TableName;
  }

  /**
   * Update an existing ...
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1
   *                            );
   *
   * @param Mgallegos\DecimaAccounting\Account $TableName
   *
   * @return boolean
   */
  public function update(array $data, $TableName = null)
  {
    if(empty($TableName))
    {
      $TableName = $this->byId($data['id']);
    }

    foreach ($data as $key => $value)
    {
      $TableName->$key = $value;
    }

    return $TableName->save();
  }

}

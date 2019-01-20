<?php
/**
 * @file
 * Description of the script.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\System\Repositories\SlvSetting;

use Illuminate\Database\Eloquent\Model;

use App\Kwaai\System\SlvSetting;

class EloquentSlvSetting implements SlvSettingInterface {

  /**
   * SlvSetting
   *
   * @var App\Kwaai\System\SlvSetting;
   *
   */
  protected $SlvSetting;

  /**
   * Database Connection
   *
   * @var string
   *
   */
  protected $databaseConnectionName;

  public function __construct(Model $SlvSetting, $databaseConnectionName = 'default')
  {
    $this->SlvSetting = $SlvSetting;

    $this->databaseConnectionName = $databaseConnectionName;

    $this->SlvSetting->setConnection($databaseConnectionName);
  }

  /**
   * Get table name
   *
   * @return string
   */
  public function getTable()
  {
    return $this->SlvSetting->getTable();
  }

  /**
   * Get a ... by ID
   *
   * @param  int $id
   *
   * @return App\Kwaai\System\SlvSetting
   */
  public function byId($id, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

  	return $this->SlvSetting->on($databaseConnectionName)->find($id);
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

    return $this->SlvSetting->setConnection($databaseConnectionName)->where('organization_id', '=', $id)->get();
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

    return $this->SlvSetting->setConnection($databaseConnectionName)
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

    $SlvSetting = new SlvSetting();
    $SlvSetting->setConnection($databaseConnectionName);
    $SlvSetting->fill($data)->save();

    return $SlvSetting;
  }

  /**
   * Update an existing ...
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1
   *                            );
   *
   * @param App\Kwaai\System\SlvSetting $SlvSetting
   *
   * @return boolean
   */
  public function update(array $data, $SlvSetting = null, $databaseConnectionName = null)
  {
    if(empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->databaseConnectionName;
    }

    if(empty($SlvSetting))
    {
      $SlvSetting = $this->byId($data['id'], $databaseConnectionName);
    }

    foreach ($data as $key => $value)
    {
      $SlvSetting->$key = $value;
    }

    return $SlvSetting->save();
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
      $SlvSetting = $this->byId($id, $databaseConnectionName);
      $SlvSetting->delete();
    }
    // $this->Account->destroy($data);

    return true;
  }

}

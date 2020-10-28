<?php
/**
 * @file
 * Module App Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Vendor\DecimaModule\Module\Services\ModuleAppManagement;

use App\Kwaai\System\Services\Validation\AbstractLaravelValidator;
use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;
use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface;
use App\Kwaai\Security\Repositories\Journal\JournalInterface;
use Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface;
use Vendor\DecimaModule\Module\Repositories\ModuleTableName\EloquentModuleTableNameGridRepository;
use Vendor\DecimaModule\Module\Repositories\ModuleTableName\ModuleTableNameInterface;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Illuminate\Translation\Translator;
use Illuminate\Config\Repository;
use Illuminate\Cache\CacheManager;

class ModuleAppManager extends AbstractLaravelValidator implements ModuleAppManagementInterface {

  /**
   * Authentication Management Interface
   *
   * @var App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface
   *
   */
  protected $AuthenticationManager;

  /**
  * Journal Management Interface (Security)
  *
  * @var App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface
  *
  */
  protected $JournalManager;

  /**
  * Journal (Security)
  *
  * @var App\Kwaai\Security\Repositories\Journal\JournalInterface
  *
  */
  protected $Journal;

  /**
	 * Grid Encoder
	 *
	 * @var Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface
	 *
	 */
	protected $GridEncoder;

  /**
	 * Eloquent Grid Repository
	 *
	 * @var Vendor\DecimaModule\Module\Repositories\ModuleTableName\EloquentModuleTableNameGridRepository
	 *
	 */
	protected $EloquentModuleTableNameGridRepository;

  /**
	 *  Module Table Name Interface
	 *
	 * @var Vendor\DecimaModule\Module\Repositories\ModuleTableName\ModuleTableNameInterface
	 *
	 */
	protected $ModuleTableName;

  /**
   * Carbon instance
   *
   * @var Carbon\Carbon
   *
   */
  protected $Carbon;

  /**
   * Laravel Database Manager
   *
   * @var Illuminate\Database\DatabaseManager
   *
   */
  protected $DB;

  /**
   * Laravel Translator instance
   *
   * @var Illuminate\Translation\Translator
   *
   */
  protected $Lang;

  /**
   * Laravel Repository instance
   *
   * @var Illuminate\Config\Repository
   *
   */
  protected $Config;

  /**
  * Laravel Cache instance
  *
  * @var \Illuminate\Cache\CacheManager
  *
  */
  protected $Cache;

	public function __construct(
    AuthenticationManagementInterface $AuthenticationManager,
    JournalManagementInterface $JournalManager,
    JournalInterface $Journal,
    RequestedDataInterface $GridEncoder,
    EloquentModuleTableNameGridRepository $EloquentModuleTableNameGridRepository,
    ModuleTableNameInterface $ModuleTableName,
    Carbon $Carbon,
    DatabaseManager $DB,
    Translator $Lang,
    Repository $Config,
    CacheManager $Cache
  )
	{
    $this->AuthenticationManager = $AuthenticationManager;
    $this->JournalManager = $JournalManager;
    $this->Journal = $Journal;
    $this->GridEncoder = $GridEncoder;
    $this->EloquentModuleTableNameGridRepository = $EloquentModuleTableNameGridRepository;
    $this->ModuleTableName = $ModuleTableName;
    $this->Carbon = $Carbon;
    $this->DB = $DB;
		$this->Lang = $Lang;
		$this->Config = $Config;
    $this->Cache = $Cache;
	}

  /**
   * Echo grid data in a jqGrid compatible format
   *
   * @param array $post
   *	All jqGrid posted data
   *
   * @return void
   */
  public function getGridData(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentModuleTableNameGridRepository, $post);
  }

  /**
   * Get search modal table rows
   *
   * @return array
   */
  public function getSearchModalTableRows($id = null, $input, $pager = false, $organizationId = null, $databaseConnectionName = null, $returnJson = true)
  {
    $rows = array();
    $limit = $offset = $count = 0;
    $filter = '';

    if(empty($organizationId))
    {
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
    }

    if(!empty($input['filter']))
    {
      $filter = $input['filter'];
    }

    if($pager)
    {
      $count = $this->ModuleTableName->searchModalTableRows($id, $organizationId, true, $limit, $offset, $filter, $databaseConnectionName);

      encode_requested_data(
        $input,
        $count,
        $limit,
        $offset
      );
    }

    $this->ModuleTableName->searchModalTableRows($id, $organizationId, false, $limit, $offset, $filter, $databaseConnectionName)->each(function($ModuleTableName) use (&$rows)
    {
      $rows['key' . $ModuleTableName->id] = (array)$ModuleTableName;
    });

    $rows = array(
      'from' => $offset,
      'to' => $limit,
      'page' => !empty($input['page']) ? (int)$input['page'] : 1,
      'records' => $count,
      'rows' => $rows
    );
    
    if($returnJson)
    {
      return json_encode($rows);
    }

    return $rows;
  }

  /**
   * Get ...
   *
   * @return mixed Illuminate\Database\Eloquent\Model if not empty, false if empty
   */
  public function getModuleTableName($id, $databaseConnectionName = null)
  {
    $ModuleTableName = $this->ModuleTableName->byId($id, $databaseConnectionName);

    if(empty($ModuleTableName))
    {
      return false;
    }

    return $ModuleTableName;
  }

  /**
   * Get ...
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getModuleTableNames($organizationId = null, $databaseConnectionName = null, $returnJson = false)
  {
    $moduleTableNames = array();

    if(!empty($organizationId) && empty($databaseConnectionName))
    {
      $databaseConnectionName = $this->AuthenticationManager->getCurrentUserOrganizationConnection((int)$organizationId);
    }

    if(empty($organizationId))
    {
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
    }

    // if(!$this->Cache->has('moduleTableNames' . $organizationId))
    // {
    //   $this->ModuleTableName->byOrganization($organizationId)->each(function($ModuleTableName) use (&$moduleTableNames)
    //   {
    //     array_push($moduleTableNames, array('label'=> $ModuleTableName->name , 'value'=>$ModuleTableName->id));
    //   });
    //
    //   $this->Cache->put('moduleTableNames' . $organizationId, json_encode($moduleTableNames), 360);
    // }
    // else
    // {
    //   $moduleTableNames = json_decode($this->Cache->get('moduleTableNames' . $organizationId), true);
    // }

    $this->ModuleTableName->byOrganization($organizationId, $databaseConnectionName)->each(function($ModuleTableName) use (&$moduleTableNames)
    {
      array_push(
        $moduleTableNames,
        array(
          'label'=> $ModuleTableName->name ,
          'value'=>$ModuleTableName->id
        )
      );
    });

    if($returnJson)
    {
      return json_encode($moduleTableNames);
    }

    return $moduleTableNames;
  }

  /**
	 * Create a new ...
	 *
	 * @param array $input
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1
   *                            );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessSaveMessage}
	 */
	public function create(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
	{
    unset(
      $input['_token']
    );

    if(!empty($input['token']))
    {
      $token = !empty($input['token']) ? $input['token'] : '';
      $loggedUser = $this->AuthenticationManager->getApiLoggedUser($token, false);

      if(empty($loggedUser))
      {
        $this->Log->warning('[SECURITY EVENT] Action - Invalid token', array(
          'error' => 'Invalid token', 
          'errorCode' => '001',
        ));

        return response()->json(['error' => 'Invalid token', 'errorCode' => '001']);
      }

      unset( $input['token'] );

      $databaseConnectionName = $loggedUser['database_connection_name'];
      $organizationId = $loggedUser['organization_id'];
      $loggedUserId = $loggedUser['id'];
    }

    $input = eloquent_array_filter_for_insert($input);

    if(empty($organizationId))
    {
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
    }

    if(empty($loggedUserId))
    {
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
    }

		$input = array_add($input, 'organization_id', $organizationId);
    // $input = array_add($input, 'created_by', $loggedUserId);
    // $input['date'] = $this->Carbon->createFromFormat($this->Lang->get('form.phpShortDateFormat'), $input['date'])->format('Y-m-d');
    // $input['amount'] = remove_thousands_separator($input['amount']);

    $this->beginTransaction($openTransaction, $databaseConnectionName);

    try
		{
      $ModuleTableName = $this->ModuleTableName->create($input, $databaseConnectionName);

      $Journal = $this->Journal->create(array('journalized_id' => $ModuleTableName->id, 'journalized_type' => $this->ModuleTableName->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.addedJournal', array('name' => $ModuleTableName->name)), $Journal));

      // $this->Cache->forget('moduleTableNamesSmt' . $organizationId);

      $this->commit($openTransaction);
    }
    catch (\Exception $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }
    catch (\Throwable $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }

    return json_encode(
      array(
        'success' => $this->Lang->get('form.defaultSuccessSaveMessage'),
        'smtRow' => $this->getSearchModalTableRows(
          $ModuleTableName->id,
          array(),
          false,
          $organizationId, 
          $databaseConnectionName, 
          false
        )
      )
    );
  }

  /**
   * Update an existing ...
   *
   * @param array $input
   * 	An array as follows: array('id' => $id, 'field0'=>$field0, 'field1'=>$field1
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessUpdateMessage}
   */
  public function update(array $input, $ModuleTableName = null, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
  {
    // if(isset($input['table_name_label']))
    // {
    //   $newValues['table_name_id'] = $input['table_name_label'];
    // }

    unset(
      $input['_token']
    );

    if(!empty($input['token']))
    {
      $token = !empty($input['token']) ? $input['token'] : '';
      $loggedUser = $this->AuthenticationManager->getApiLoggedUser($token, false);

      if(empty($loggedUser))
      {
        $this->Log->warning('[SECURITY EVENT] Action - Invalid token', array(
          'error' => 'Invalid token', 
          'errorCode' => '001',
        ));

        return response()->json(['error' => 'Invalid token', 'errorCode' => '001']);
      }

      unset( $input['token'] );

      $databaseConnectionName = $loggedUser['database_connection_name'];
      $organizationId = $loggedUser['organization_id'];
      $loggedUserId = $loggedUser['id'];
    }

    $input = eloquent_array_filter_for_update($input);

    // if(!empty($input['date']))
    // {
    //   $input['date'] = $this->Carbon->createFromFormat($this->Lang->get('form.phpShortDateFormat'), $input['date'])->format('Y-m-d');
    // }

    // if(!empty($input['amount']))
    // {
    //   $input['amount'] = remove_thousands_separator($input['amount']);
    // }

    if(empty($organizationId))
    {
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
    }

    if(empty($loggedUserId))
    {
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
    }

    $this->beginTransaction($openTransaction, $databaseConnectionName);

    try
    {
      if(empty($ModuleTableName))
      {
        $ModuleTableName = $this->ModuleTableName->byId($input['id'], $databaseConnectionName);
      }

      $unchangedValues = $ModuleTableName->toArray();

      $this->ModuleTableName->update($input, $ModuleTableName);

      $diff = 0;

      foreach ($input as $key => $value)
      {
        if($unchangedValues[$key] != $value)
        {
          $diff++;

          if($diff == 1)
          {
            $Journal = $this->Journal->create(array('journalized_id' => $ModuleTableName->id, 'journalized_type' => $this->ModuleTableName->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
          }

          if($key == 'status')//Para autocomple de estados
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('form.status'), 'field_lang_key' => 'form.status', 'old_value' => $this->Lang->get('form.' . $unchangedValues[$key]), 'new_value' => $this->Lang->get('form.' . $value)), $Journal);
          }
          else if ($key == 'field1')
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('module::app.field1'), 'field_lang_key' => 'module::app.field1', 'old_value' => $unchangedValues[$key], 'new_value' => $value), $Journal);
          }
          else if ($key == 'name')
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('form.' . camel_case($key)), 'field_lang_key' => 'form.' . camel_case($key), 'old_value' => $unchangedValues[$key], 'new_value' => $value), $Journal);
          }
          else if ($key == 'chekbox0' || $key == 'chekbox1')
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('module::app.' . camel_case($key)), 'field_lang_key' => 'module::app.' . camel_case($key), 'old_value' => $this->Lang->get('journal.' . $unchangedValues[$key]), 'new_value' => $this->Lang->get('journal.' . $value)), $Journal);
          }
          else if($key == 'date')
          {
            if(!empty($unchangedValues[$key]))
            {
              $oldValue = $this->Carbon->createFromFormat('Y-m-d', $unchangedValues[$key], 'UTC')->format($this->Lang->get('form.phpShortDateFormat'));
            }
            else
            {
              $oldValue = '';
            }

            if(!empty($value))
            {
              $newValue = $this->Carbon->createFromFormat('Y-m-d', $value, 'UTC')->format($this->Lang->get('form.phpShortDateFormat'));
            }
            else
            {
              $newValue = '';
            }

            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('module::app.' . camel_case($key)), 'field_lang_key' => 'module::app.' . camel_case($key), 'old_value' => $oldValue, 'new_value' => $newValue), $Journal);
          }
          else if($key == 'table_name_id')//field required
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('module::app.' . camel_case($key)), 'field_lang_key' => 'module::app.' . camel_case($key), 'old_value' => $this->TableName->byId($unchangedValues[$key], $databaseConnectionName)->name, 'new_value' => $newValues[$key]), $Journal);
          }
          else if($key == 'table_name_id')//field not required
          {
            if(!empty($unchangedValues[$key]))
            {
              $oldValue = $this->TableName->byId($unchangedValues[$key], $databaseConnectionName)->name;
            }
            else
            {
              $oldValue = '';
            }

            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('module::app.' . camel_case($key)), 'field_lang_key' => 'module::app.' . camel_case($key), 'old_value' => $oldValue, 'new_value' => $newValues[$key]), $Journal);
          }
          else
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('module::app.' . camel_case($key)), 'field_lang_key' => 'module::app.' . camel_case($key), 'old_value' => $unchangedValues[$key], 'new_value' => $value), $Journal);
          }
        }
      }

      // $this->Cache->forget('moduleTableNamesSmt' . $organizationId);

      $this->commit($openTransaction);
    }
    catch (\Exception $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }
    catch (\Throwable $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }

    return json_encode(
      array(
        'success' => $this->Lang->get('form.defaultSuccessUpdateMessage'),
        'smtRow' => $this->getSearchModalTableRows(
          $ModuleTableName->id, 
          array(),
          false,
          $organizationId, 
          $databaseConnectionName, 
          false
        )
      )
    );
  }

  /**
   * Delete an existing ... (soft delete)
   *
   * @param array $input
	 * 	An array as follows: array(id => $id);
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessDeleteMessage}
   */
  public function delete0(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
  {
    if(!empty($input['token']))
    {
      $token = !empty($input['token']) ? $input['token'] : '';
      $loggedUser = $this->AuthenticationManager->getApiLoggedUser($token, false);

      if(empty($loggedUser))
      {
        $this->Log->warning('[SECURITY EVENT] Action - Invalid token', array(
          'error' => 'Invalid token', 
          'errorCode' => '001',
        ));

        return response()->json(['error' => 'Invalid token', 'errorCode' => '001']);
      }

      unset( $input['token'] );

      $databaseConnectionName = $loggedUser['database_connection_name'];
      $organizationId = $loggedUser['organization_id'];
      $loggedUserId = $loggedUser['id'];
    }

    if(empty($organizationId))
    {
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
    }

    if(empty($loggedUserId))
    {
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
    }

    $this->beginTransaction($openTransaction, $databaseConnectionName);

    try
    {
      $ModuleTableName = $this->ModuleTableName->byId($input['id'], $databaseConnectionName);

      $Journal = $this->Journal->create(array('journalized_id' => $input['id'], 'journalized_type' => $this->ModuleTableName->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.deletedJournal', array('name' => $ModuleTableName->name)), $Journal));

      $this->ModuleTableName->delete(array($input['id']), $databaseConnectionName);

      // $this->Cache->forget('moduleTableNamesSmt' . $organizationId);

      $this->commit($openTransaction);
    }
    catch (\Exception $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }
    catch (\Throwable $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }

    return json_encode(
      array(
        'success' => $this->Lang->get('form.defaultSuccessDeleteMessage'),
        'smtRowId' => $input['id']
      )
    );
  }

  /**
   * Delete existing ... (soft delete)
   *
   * @param array $input
	 * 	An array as follows: array($id0, $id1,…);
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessDeleteMessage}
   */
   public function delete1(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
   {
    $count = 0;

    if(!empty($input['token']))
    {
      $token = !empty($input['token']) ? $input['token'] : '';
      $loggedUser = $this->AuthenticationManager->getApiLoggedUser($token, false);

      if(empty($loggedUser))
      {
        $this->Log->warning('[SECURITY EVENT] Action - Invalid token', array(
          'error' => 'Invalid token', 
          'errorCode' => '001',
        ));

        return response()->json(['error' => 'Invalid token', 'errorCode' => '001']);
      }

      unset( $input['token'] );

      $databaseConnectionName = $loggedUser['database_connection_name'];
      $organizationId = $loggedUser['organization_id'];
      $loggedUserId = $loggedUser['id'];
    }

    if(empty($organizationId))
    {
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
    }

    if(empty($loggedUserId))
    {
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
    }

    $this->beginTransaction($openTransaction, $databaseConnectionName);

    try
    {
      foreach ($input['id'] as $key => $id)
      {
        $count++;

        $ModuleTableName = $this->ModuleTableName->byId($id, $databaseConnectionName);

        $Journal = $this->Journal->create(array('journalized_id' => $id, 'journalized_type' => $this->ModuleTableName->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.deletedJournal', array('name' => $ModuleTableName->name))), $Journal);

        $this->ModuleTableName->delete(array($id), $databaseConnectionName);
      }

      // $this->Cache->forget('moduleTableNamesSmt' . $organizationId);

      $this->commit($openTransaction);
    }
    catch (\Exception $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }
    catch (\Throwable $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }


    if($count == 1)
    {
      return json_encode(
        array(
          'success' => $this->Lang->get('form.defaultSuccessDeleteMessage'),
          'smtRowIds' => $input['id']
        )
      );
    }
    else
    {
      return json_encode(
        array(
          'success' => $this->Lang->get('form.defaultSuccessDeleteMessage1'),
          'smtRowIds' => $input['id']
        )
      );
    }
  }
}

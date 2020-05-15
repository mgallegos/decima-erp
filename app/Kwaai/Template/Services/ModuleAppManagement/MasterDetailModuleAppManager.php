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
use Vendor\DecimaModule\Module\Repositories\ModuleApp\EloquentModuleAppGridRepository;
use Vendor\DecimaModule\Module\Repositories\ModuleAppDetail\EloquentModuleAppDetailGridRepository;
use Vendor\DecimaModule\Module\Repositories\ModuleApp\ModuleAppInterface;
use Vendor\DecimaModule\Module\Repositories\ModuleAppDetail\ModuleAppDetailInterface;
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
	 * Eloquent ModuleApp Grid Repository
	 *
	 * @var Vendor\DecimaModule\Module\Repositories\ModuleApp\EloquentModuleAppGridRepository
	 *
	 */
	protected $EloquentModuleAppGridRepository;

  /**
	 * Eloquent ModuleApp Detail Grid Repository
	 *
	 * @var Vendor\DecimaModule\Module\Repositories\ModuleAppDetail\EloquentModuleAppDetailGridRepository
	 *
	 */
	protected $EloquentModuleAppDetailGridRepository;

  /**
	 *  ModuleApp Interface
	 *
	 * @var Vendor\DecimaModule\Module\Repositories\ModuleApp\ModuleAppInterface
	 *
	 */
	protected $ModuleApp;

  /**
	 *  ModuleApp Detail Interface
	 *
	 * @var Vendor\DecimaModule\Module\Repositories\ModuleAppDetail\ModuleAppDetailInterface
	 *
	 */
	protected $ModuleAppDetail;

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
    EloquentModuleAppGridRepository $EloquentModuleAppGridRepository,
    EloquentModuleAppDetailGridRepository $EloquentModuleAppDetailGridRepository,
    ModuleAppInterface $ModuleApp,
    ModuleAppDetailInterface $ModuleAppDetail,
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

    $this->EloquentModuleAppGridRepository = $EloquentModuleAppGridRepository;

    $this->EloquentModuleAppDetailGridRepository = $EloquentModuleAppDetailGridRepository;

    $this->ModuleApp = $ModuleApp;

    $this->ModuleAppDetail = $ModuleAppDetail;

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
  public function getGridDataMaster(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentModuleAppGridRepository, $post);
  }

  /**
   * Echo grid data in a jqGrid compatible format
   *
   * @param array $post
   *	All jqGrid posted data
   *
   * @return void
   */
  public function getGridDataDetail(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentModuleAppDetailGridRepository, $post);
  }

  /**
   * Get search modal table rows
   *
   * @return array
   */
  public function getSearchModalTableRows($id = null, $input, $pager = false, $organizationId = null, $databaseConnectionName = null, $returnJson = true)
  {
    $rows = array();
    $limit = $offset = 0;
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

    if($pager)
    {
      $rows = array(
        'from' => $offset,
        'to' => $limit,
        'page' => !empty($input['page'])?$input['page']:1,
        'records' => $count,
        'rows' => $rows
      );
    }
    else
    {
      $rows = array(
        'rows' => $rows
      );
    }

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
  public function getModuleApp($id, $databaseConnectionName = null)
  {
    $ModuleApp = $this->ModuleApp->byId($id, $databaseConnectionName);

    if(empty($ModuleApp))
    {
      return false;
    }

    return $ModuleApp;
  }

  /**
   * Get ...
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getModuleApps()
  {
    $ModuleApps = array();

    $this->ModuleApp->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($ModuleApp) use (&$ModuleApps)
    {
      array_push($ModuleApps, array('label'=> $ModuleApp->name , 'value'=>$ModuleApp->id));
    });

    return $ModuleApps;
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
	public function createMaster(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
	{
    unset(
      $input['_token']
    );

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
    // $input = array_add($input, 'number', $this->ModuleApp->getMaxNumber($organizationId, $databaseConnectionName) + 1);

    // if(!empty($input['date']))
    // {
    //   $input['date'] = $this->Carbon->createFromFormat($this->Lang->get('form.phpShortDateFormat'), $input['date'])->format('Y-m-d');
    // }

    // if(!empty($input['amount']))
    // {
    //   $input['amount'] = remove_thousands_separator($input['amount']);
    // }

    $this->beginTransaction($openTransaction, $databaseConnectionName);

    try
		{
      $ModuleApp = $this->ModuleApp->create($input, $databaseConnectionName);

      $Journal = $this->Journal->create(array('journalized_id' => $ModuleApp->id, 'journalized_type' => $this->ModuleApp->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.addedMasterJournal', array('name' => $ModuleApp->name)), $Journal));

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
        'id' => $ModuleApp->id,
        // 'smtRow' => $this->getSearchModalTableRows($ModuleApp->id, $organizationId, $databaseConnectionName, false)
      )
    );
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
	public function createDetail(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
	{
    unset(
      $input['_token']
    );

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

    // if(!empty($input['date']))
    // {
    //   $input['date'] = $this->Carbon->createFromFormat($this->Lang->get('form.phpShortDateFormat'), $input['date'])->format('Y-m-d');
    // }

    // if(!empty($input['amount']))
    // {
    //   $input['amount'] = remove_thousands_separator($input['amount']);
    // }

    $this->beginTransaction($openTransaction, $databaseConnectionName);

    try
		{
      $ModuleAppDetail = $this->ModuleAppDetail->create($input, $databaseConnectionName);
      $ModuleApp = $this->ModuleApp->byId($ModuleAppDetail->master_id, $databaseConnectionName);

      $Journal = $this->Journal->create(array('journalized_id' => $ModuleAppDetail->master_id, 'journalized_type' => $this->ModuleApp->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.addedDetailJournal', array('detailName' => $ModuleAppDetail->name, 'masterName' => $ModuleApp->name)), $Journal));

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
        'success' => $this->Lang->get('form.defaultSuccessUpdateMessage')
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
  public function updateMaster(array $input, $ModuleApp = null, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
  {
    // if(!empty($input['table_name_label']))
    // {
    //   $newValues['table_name_id'] = $input['table_name_label'];
    // }

    unset(
      $input['_token']
    );

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
      if(empty($ModuleApp))
      {
        $ModuleApp = $this->ModuleApp->byId($input['id'], $databaseConnectionName);
      }

      $unchangedValues = $ModuleApp->toArray();

      $this->ModuleApp->update($input, $ModuleApp);

      $diff = 0;

      foreach ($input as $key => $value)
      {
        if($unchangedValues[$key] != $value)
        {
          $diff++;

          if($diff == 1)
          {
            $Journal = $this->Journal->create(array('journalized_id' => $ModuleApp->id, 'journalized_type' => $this->ModuleApp->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
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
        // 'smtRow' => $this->getSearchModalTableRows($ModuleApp->id, $organizationId, $databaseConnectionName, false)
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
  public function updateDetail(array $input, $ModuleAppDetail = null, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
  {
    // if(!empty($input['table_name_label']))
    // {
    //   $newValues['table_name_id'] = $input['table_name_label'];
    // }

    unset(
      $input['_token']
    );

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
      if(empty($ModuleAppDetail))
      {
        $ModuleAppDetail = $this->ModuleAppDetail->byId($input['id'], $databaseConnectionName);
      }

      $unchangedValues = $ModuleAppDetail->toArray();

      $this->ModuleAppDetail->update($input, $ModuleAppDetail);

      $diff = 0;

      foreach ($input as $key => $value)
      {
        if($unchangedValues[$key] != $value)
        {
          $diff++;

          if($diff == 1)
          {
            $Journal = $this->Journal->create(array('journalized_id' => $ModuleAppDetail->master_id, 'journalized_type' => $this->ModuleApp->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
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

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessUpdateMessage')));
  }

  /**
   * Authorize an existing ...
   *
   * @param array $input
	 * 	An array as follows: array(id => $id);
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessDeleteMessage}
   */
  public function authorizeMaster(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
  {
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
      $ModuleApp = $this->ModuleApp->byId($input['id'], $databaseConnectionName);

      if($ModuleApp->status == 'U')
      {
        return json_encode(
          array(
            'info' => $this->Lang->get('form.defaultAlreadyAuthorizeMessage')
          )
        );
      }

      $this->updateMaster(
        array(
          'id' => $ModuleApp->id,
          'status' => 'U'
        ),
        $ModuleApp,
        false,
        $databaseConnectionName,
        $organizationId,
        $loggedUserId
      );

      $Journal = $this->Journal->create(array('journalized_id' => $input['id'], 'journalized_type' => $this->ModuleApp->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.authorizedMasterJournal', array('number' => $ModuleApp->number)), $Journal));

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
        'success' => $this->Lang->get('form.defaultAuthorizeMessage'),
        'newStatus' => 'U',
        // 'smtRow' => $this->getSearchModalTableRows($ModuleApp->id, $organizationId, $databaseConnectionName, false)
      )
    );
  }

  /**
   * Void an existing ...
   *
   * @param array $input
	 * 	An array as follows: array(id => $id);
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessDeleteMessage}
   */
  public function voidMaster(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
  {
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
      $ModuleApp = $this->ModuleApp->byId($input['id'], $databaseConnectionName);

      if($ModuleApp->status == 'A')
      {
        return json_encode(
          array(
            'info' => $this->Lang->get('form.defaultAlreadyVoidMessage')
          )
        );
      }

      $this->updateMaster(
        array(
          'id' => $ModuleApp->id,
          'status' => 'A'
        ),
        $ModuleApp,
        false,
        $databaseConnectionName,
        $organizationId,
        $loggedUserId
      );

      $Journal = $this->Journal->create(array('journalized_id' => $input['id'], 'journalized_type' => $this->ModuleApp->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.voidMasterJournal', array('number' => $ModuleApp->number)), $Journal));

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
        'success' => $this->Lang->get('form.defaultVoidMessage'),
        'newStatus' => 'A',
        // 'smtRow' => $this->getSearchModalTableRows($ModuleApp->id, $organizationId, $databaseConnectionName, false)
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
  public function deleteMaster(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
  {
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
      $ModuleApp = $this->ModuleApp->byId($input['id'], $databaseConnectionName);

      $Journal = $this->Journal->create(array('journalized_id' => $input['id'], 'journalized_type' => $this->ModuleApp->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.deletedMasterJournal', array('name' => $ModuleApp->name)), $Journal));

      $this->ModuleApp->delete(array($input['id']), $databaseConnectionName);

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
        // 'smtRowId' => $input['id']
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
   public function deleteDetails(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
   {
     $count = 0;

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

         $ModuleAppDetail = $this->ModuleAppDetail->byId($id, $databaseConnectionName);

         if(empty($ModuleApp))
         {
           $ModuleApp = $this->ModuleApp->byId($ModuleAppDetail->master_id, $databaseConnectionName);
         }

         $Journal = $this->Journal->create(array('journalized_id' => $ModuleAppDetail->master_id, 'journalized_type' => $this->ModuleApp->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
         $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.deletedDetailJournal', array('detailName' => $ModuleAppDetail->name, 'masterName' => $ModuleApp->name))), $Journal);

         $this->ModuleAppDetail->delete(array($id), $databaseConnectionName);
       }

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
       return json_encode(array('success' => $this->Lang->get('form.defaultSuccessDeleteMessage')));
     }
     else
     {
       return json_encode(array('success' => $this->Lang->get('form.defaultSuccessDeleteMessage1')));
     }
   }
}

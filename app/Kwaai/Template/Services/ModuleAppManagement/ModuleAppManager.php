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

use Illuminate\Config\Repository;

use Illuminate\Translation\Translator;

use Illuminate\Database\DatabaseManager;


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

	public function __construct(AuthenticationManagementInterface $AuthenticationManager, JournalManagementInterface $JournalManager, JournalInterface $Journal, RequestedDataInterface $GridEncoder, EloquentModuleTableNameGridRepository $EloquentModuleTableNameGridRepository, ModuleTableNameInterface $ModuleTableName, Carbon $Carbon, DatabaseManager $DB, Translator $Lang, Repository $Config)
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
   * Get ...
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getModuleTableNames()
  {
    $moduleTableNames = array();

    $this->ModuleTableName->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($ModuleTableName) use (&$moduleTableNames)
    {
      array_push($moduleTableNames, array('label'=> $ModuleTableName->name , 'value'=>$ModuleTableName->id));
    });

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
    unset($input['_token']);

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

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
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
    unset($input['_token']);

    $input = eloquent_array_filter_for_update($input);
    // $input['date'] = $this->Carbon->createFromFormat($this->Lang->get('form.phpShortDateFormat'), $input['date'])->format('Y-m-d');
    // $input['amount'] = remove_thousands_separator($input['amount']);

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
        $ModuleTableName = $this->ModuleTableName->byId($input['id']);
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
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('module::app.field1'), 'field_lang_key' => 'module::app.field1', 'old_value' => ' ', 'new_value' => ''), $Journal);
          }
          else if ($key == 'name')
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('form.' . camel_case($key)), 'field_lang_key' => 'form.' . camel_case($key), 'old_value' => $unchangedValues[$key], 'new_value' => $value), $Journal);
          }
          else if ($key == 'chekbox0' || $key == 'chekbox1')
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('module::app.' . camel_case($key)), 'field_lang_key' => 'module::app.' . camel_case($key), 'old_value' => $this->Lang->get('journal.' . $unchangedPaymentFormValues[$key]), 'new_value' => $this->Lang->get('journal.' . $value)), $Journal);
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
      $ModuleTableName = $this->ModuleTableName->byId($input['id']);

      $Journal = $this->Journal->create(array('journalized_id' => $input['id'], 'journalized_type' => $this->ModuleTableName->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.deletedJournal', array('number' => $ModuleTableName->number)), $Journal));

      $this->ModuleTableName->delete(array($input['id']));

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

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessDeleteMessage')));
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
       $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
       $organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');

       foreach ($input['id'] as $key => $id)
       {
         $count++;

         $ModuleTableName = $this->ModuleTableName->byId($id);

         $Journal = $this->Journal->create(array('journalized_id' => $id, 'journalized_type' => $this->ModuleTableName->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
         $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.deletedJournal', array('email' => $ModuleTableName->email, 'organization' => $organizationName))), $Journal);

         $this->ModuleTableName->delete(array($id));
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

<?php
/**
 * @file
 * Module App Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\System\Services\SettingManagement;

use App\Kwaai\System\Services\Validation\AbstractLaravelValidator;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface;

use App\Kwaai\Security\Repositories\Journal\JournalInterface;

use Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface;

use App\Kwaai\System\Repositories\SlvSetting\SlvSettingInterface;

use Carbon\Carbon;

use Illuminate\Database\DatabaseManager;

use Illuminate\Translation\Translator;

use Illuminate\Config\Repository;

use Illuminate\Cache\CacheManager;

class SettingManager extends AbstractLaravelValidator implements SettingManagementInterface {

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
	 *  SLV Setting Interface
	 *
	 * @var App\Kwaai\System\Repositories\SlvSetting\SlvSettingInterface
	 *
	 */
	protected $SlvSetting;

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
    SlvSettingInterface $SlvSetting,
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

    $this->SlvSetting = $SlvSetting;

    $this->Carbon = $Carbon;

    $this->DB = $DB;

		$this->Lang = $Lang;

		$this->Config = $Config;
	}

  /**
   * Get ...
   *
   * @return mixed Illuminate\Database\Eloquent\Model if not empty, false if empty
   */
  public function getSlvSetting($organizationId = null, $databaseConnectionName = null)
  {
    if(empty($organizationId))
    {
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
    }
    
    $SlvSetting = $this->SlvSetting->byOrganization($organizationId, $databaseConnectionName);

    if($SlvSetting->isEmpty())
    {
      $SlvSetting = $this->createSlv(array());
    }
    else
    {
      $SlvSetting = $SlvSetting->first();
    }

    return $SlvSetting;
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
	public function createSlv(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
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
      $SlvSetting = $this->SlvSetting->create($input, $databaseConnectionName);

      // $Journal = $this->Journal->create(array('journalized_id' => $SlvSetting->id, 'journalized_type' => $this->SlvSetting->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      // $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('module::app.addedJournal', array('name' => $SlvSetting->name)), $Journal));

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

    return $SlvSetting;

    // return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
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
  public function updateSlv(array $input, $SlvSetting = null, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
  {
    // $newValues['table_name_id'] = $input['table_name_label'];

    unset($input['_token']);

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
      if(empty($SlvSetting))
      {
        $SlvSetting = $this->SlvSetting->byId($input['id'], $databaseConnectionName);
      }

      $unchangedValues = $SlvSetting->toArray();

      $this->SlvSetting->update($input, $SlvSetting);

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
}

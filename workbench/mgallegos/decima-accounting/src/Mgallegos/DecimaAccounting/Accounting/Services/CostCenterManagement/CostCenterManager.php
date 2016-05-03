<?php
/**
 * @file
 * Cost Center Management Interface Implementation.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Services\CostCenterManagement;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface as SecurityJournalManagementInterface;

use App\Kwaai\Security\Repositories\Journal\JournalInterface;

use Mgallegos\LaravelJqgrid\Encoders\RequestedDataInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\EloquentCostCenterGridRepository;

use Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\CostCenterInterface;

use Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface;

use Carbon\Carbon;

use Illuminate\Config\Repository;

use Illuminate\Translation\Translator;

use Illuminate\Database\DatabaseManager;

class CostCenterManager implements CostCenterManagementInterface {

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
	 * Eloquent Journal Voucher Grid Repository
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\EloquentCostCenterGridRepository
	 *
	 */
	protected $EloquentCostCenterGridRepository;

  /**
  * CostCenter Interface
  *
  * @var Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\CostCenterInterface
  *
  */
  protected $CostCenter;

  /**
   * Journal Entry Interface
   *
   * @var Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface
   *
   */
  protected $JournalEntry;

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

	public function __construct(AuthenticationManagementInterface $AuthenticationManager, SecurityJournalManagementInterface $JournalManager, JournalInterface $Journal, RequestedDataInterface $GridEncoder, EloquentCostCenterGridRepository $EloquentCostCenterGridRepository, CostCenterInterface $CostCenter, JournalEntryInterface $JournalEntry, Carbon $Carbon, DatabaseManager $DB, Translator $Lang, Repository $Config)
	{
    $this->AuthenticationManager = $AuthenticationManager;

    $this->JournalManager = $JournalManager;

    $this->Journal = $Journal;

    $this->GridEncoder = $GridEncoder;

    $this->EloquentCostCenterGridRepository = $EloquentCostCenterGridRepository;

    $this->CostCenter = $CostCenter;

    $this->JournalEntry = $JournalEntry;

    $this->Carbon = $Carbon;

    $this->DB = $DB;

		$this->Lang = $Lang;

		$this->Config = $Config;
	}

  /**
   * Echo cost center grid data in a jqGrid compatible format
   *
   * @param array $post
   *	All jqGrid posted data
   *
   * @return void
   */
  public function getCostCenterGridData(array $post)
  {
    $this->GridEncoder->encodeRequestedData($this->EloquentCostCenterGridRepository, $post);
  }

  /**
   * Get organization cost centers
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getGroupsCostCenters()
  {
    //Is Group: Further cost centers can be made under Groups, but entries can be made against non-Groups
    $costCenters = array();

    $this->CostCenter->byOrganization($this->AuthenticationManager->getCurrentUserOrganizationId())->each(function($CostCenter) use (&$costCenters)
    {
      if($CostCenter->is_group)
      {
        array_push($costCenters, array('label'=> $CostCenter->key . ' ' . $CostCenter->name, 'value'=>$CostCenter->id));
      }
    });

    return $costCenters;
  }

  /**
	 * Create a new cost center
	 *
	 * @param array $input
   * 	An array as follows: array('key'=>$key, 'name'=>$name, 'balance_type'=>$balanceType, 'is_group'=>$isGroup,
   *                             'parent_cc_id'=>$parentCostCenterId
   *                            );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessSaveMessage}
	 */
	public function create(array $input)
	{
    unset($input['_token'], $input['parent_cc']);

    $groupsCostCenters = $info = false;

    $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
    $organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();

    $input = eloquent_array_filter_for_insert($input);
		$input = array_add($input, 'organization_id', $organizationId);

    $this->DB->transaction(function() use ($input, $loggedUserId, $organizationId, &$groupsCostCenters, &$info)
		{
      if($this->CostCenter->byOrganizationAndByKey($organizationId, $input['key'])->count() > 0)
      {
        $info = $this->Lang->get('decima-accounting::cost-center-management.keyValidationMessage', array('key' => $input['key']));
        return;
      }

      $CostCenter = $this->CostCenter->create($input);

      if(!empty($CostCenter->is_group))
      {
        $groupsCostCenters = $this->getGroupsCostCenters();
      }

      $Journal = $this->Journal->create(array('journalized_id' => $CostCenter->id, 'journalized_type' => $this->CostCenter->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::initial-accounting-setup.costCenterAddedJournal', array('costCenter' => $CostCenter->key . ' ' . $CostCenter->name)), $Journal));
    });

    if(!$info)
    {
      return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage'), 'groupsCostCenters' => $groupsCostCenters));
    }
    else
    {
      return json_encode(array('info' => $info));
    }
  }

  /**
	 * Update an existing cost center
	 *
	 * @param array $input
   * 	An array as follows: array('id' => $id, 'key'=>$key, 'name'=>$name, 'balance_type'=>$balanceType, 'is_group'=>$isGroup,
   *                             'parent_cc_id'=>$parentCostCenterId, 'parent_cc' => $parentCostCenter
   *                            );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessUpdateMessage}
	 */
	public function update(array $input)
	{
    $newParentCostCenter = $input['parent_cc'];
    $groupsCostCenters = $info = false;

    unset($input['_token'], $input['parent_cc']);
    $input = eloquent_array_filter_for_update($input);

    if($this->getCostCenterChildrenCount($input['id']) > 0 && $input['is_group'] == 0)
    {
      return json_encode(array('info' => $this->Lang->get('decima-accounting::cost-center-management.isGroupException')));
      // return json_encode(array('validationFailed' => true , 'fieldValidationMessages' => array('is-group' => $this->Lang->get('decima-accounting::cost-center-management.isGroupException'))));
    }

    $this->DB->transaction(function() use (&$input, $newParentCostCenter, &$groupsCostCenters, &$info)
		{
      $CostCenter = $this->CostCenter->byId($input['id']);
      $unchangedCostCenterValues = $CostCenter->toArray();

      if(rtrim($input['key']) != rtrim($CostCenter->key) && $this->CostCenter->byOrganizationAndByKey($this->AuthenticationManager->getCurrentUserOrganizationId(), $input['key'])->count() > 0)
      {
        $info = $this->Lang->get('decima-accounting::cost-center-management.keyValidationMessage', array('key' => $input['key']));
        return;
      }

      $this->CostCenter->update($input, $CostCenter);

      if(!empty($CostCenter->is_group))
      {
        $groupsCostCenters = $this->getGroupsCostCenters();
      }

      $diff = 0;

      foreach ($input as $key => $value)
      {
        // var_dump($unchangedCostCenterValues);die();
        if($unchangedCostCenterValues[$key] != $value)
        {
          $diff++;

          if($diff == 1)
          {
            $Journal = $this->Journal->create(array('journalized_id' => $CostCenter->id, 'journalized_type' => $this->CostCenter->getTable(), 'user_id' => $this->AuthenticationManager->getLoggedUserId(), 'organization_id' => $this->AuthenticationManager->getCurrentUserOrganizationId()));
          }

          if ($key == 'parent_cc_id')
          {
            if(!empty($unchangedCostCenterValues[$key]))
            {
              $OldParentcostCenter = $this->CostCenter->byId($unchangedCostCenterValues[$key]);
              $oldParentcostCenter = $OldParentcostCenter->key . ' ' . $OldParentcostCenter->name;
            }
            else
            {
              $oldParentcostCenter = '';
            }

            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::cost-center-management.parentCc'), 'field_lang_key' => 'decima-accounting::cost-center-management.parentCc', 'old_value' => $oldParentcostCenter, 'new_value' => $newParentCostCenter), $Journal);
          }
          else if($key == 'is_group')
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::cost-center-management.isGroupLong'), 'field_lang_key' => 'decima-accounting::cost-center-management.isGroupLong', 'old_value' => $this->Lang->get('decima-accounting::account-management.' . $unchangedCostCenterValues[$key]), 'new_value' => $this->Lang->get('decima-accounting::account-management.' . $value)), $Journal);
          }
          else
          {
            $this->Journal->attachDetail($Journal->id, array('field' => $this->Lang->get('decima-accounting::account-management.' . camel_case($key)), 'field_lang_key' => 'decima-accounting::account-management.' . camel_case($key), 'old_value' => $unchangedCostCenterValues[$key], 'new_value' => $value), $Journal);
          }
        }
      }
    });

    if(!$info)
    {
      return json_encode(array('success' => $this->Lang->get('form.defaultSuccessUpdateMessage'), 'groupsCostCenters' => $groupsCostCenters));
    }
    else
    {
      return json_encode(array('info' => $info));
    }
  }

  /**
   * Delete an existing cost center (soft delete)
   *
   * @param array $input
	 * 	An array as follows: array(id => $id);
   *
   * @return JSON encoded string
   *  A string as follows:
   *	In case of success: {"success" : form.defaultSuccessDeleteMessage}
   */
  public function delete(array $input)
  {
    $info = false;

    $this->DB->transaction(function() use ($input, &$info)
    {
      $loggedUserId = $this->AuthenticationManager->getLoggedUserId();
      $organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');
      $ids = $this->getCostCenterChildrenIds($input['id']);

      array_push($ids, $input['id']);

      if($this->JournalEntry->byCostCenterIds($ids)->count() > 0)
      {
        $info = $this->Lang->get('decima-accounting::cost-center-management.costCenterValidationMessage');
        return;
      }

      $this->CostCenter->byIds($ids)->each(function($CostCenter) use ($loggedUserId, $organizationId)
      {
        $Journal = $this->Journal->create(array('journalized_id' => $CostCenter->id, 'journalized_type' => $this->CostCenter->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
        $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-accounting::cost-center-management.ccDeletedJournal', array('cc' => $CostCenter->key . ' ' . $CostCenter->name)), $Journal));
      });

      $this->CostCenter->delete($ids);
    });

    if(!$info)
    {
      return json_encode(array('success' => $this->Lang->get('form.defaultSuccessDeleteMessage')));
    }
    else
    {
      return json_encode(array('info' => $info));
    }
  }

  /**
   * Get cost center children
   *
   * @param int $id
   *
   * @return array
   *  An array of arrays as follows: array( $id0, $id1,…)
   */
  public function getCostCenterChildrenIds($id)
  {
    $ids = array();

    $this->CostCenter->byParent($id)->each(function($CostCenter) use (&$ids)
    {
      if($CostCenter->is_group)
      {
        $ids = array_merge($ids, $this->getCostCenterChildrenIds($CostCenter->id));
      }

      array_push($ids, $CostCenter->id);
    });

    return $ids;
  }

  /**
   * Get cost centers children count
   *
   * @param int $id
   *
   * @return int
   */
  public function getCostCenterChildrenCount($id)
  {
    return $this->CostCenter->byParent($id)->count();
  }

  /**
   * Get cost centers children
   *
   * @param array $input
	 * 	An array as follows: array(id => $id);
   *
   * @return JSON encoded string
   *  A string as follows: [{"text" : $costCenterKey . " " . $costCenterName, "state" : {"opened" : true }, "icon" : $icon, "children" : [{"text" : $childCostCenterKey0 . " " . $childCostCenterName0, "icon" : $childIcon0}, …]}]
   */
  public function getCostCenterChildren($input)
  {
    $CostCenter = $this->CostCenter->byId($input['id']);

    $costCenterTree = array('text' => $CostCenter->key . ' ' . $CostCenter->name, 'state' => array('opened' => true), 'icon' => 'fa fa-sitemap', 'children' => array());

    $this->CostCenter->byParent($input['id'])->each(function($CostCenter) use (&$costCenterTree)
    {
      if($CostCenter->is_group)
      {
        array_push($costCenterTree['children'], array('text' => $CostCenter->key . ' ' . $CostCenter->name, 'icon' => 'fa fa-sitemap'));
      }
      else
      {
        array_push($costCenterTree['children'], array('text' => $CostCenter->key . ' ' . $CostCenter->name, 'icon' => 'fa fa-leaf'));
      }
    });

    return json_encode(array($costCenterTree));
  }
}

<?php
/**
 * @file
 * Journal Management Interface Implementation.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Services\JournalManagement;


use Illuminate\Config\Repository;

use App\Kwaai\Helpers\Gravatar;

use Illuminate\Translation\Translator;

use Carbon\Carbon;

use App\Kwaai\Security\Repositories\Journal\JournalInterface;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

class JournalManager implements JournalManagementInterface {

  /**
   * Journal
   *
   * @var App\Kwaai\Security\Repositories\Journal\JournalInterface
   *
   */
  protected $Journal;

  /**
   * Authentication Management Interface
   *
   * @var App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface
   *
   */
  protected $AuthenticationManager;

  /**
   * Journal App Configurations
   *
   * @var array
   *
   */
  protected $journalConfigurations;

  /**
   * Gravatar instance
   *
   * @var App\Kwaai\Helpers\Gravatar
   *
   */
  protected $Gravatar;

  /**
   * Carbon instance
   *
   * @var Carbon\Carbon
   *
   */
  protected $Carbon;

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

	public function __construct(JournalInterface $Journal, AuthenticationManagementInterface $AuthenticationManager, array $journalConfigurations, Gravatar $Gravatar, Carbon $Carbon, Translator $Lang, Repository $Config)
	{
		$this->Journal = $Journal;

		$this->AuthenticationManager = $AuthenticationManager;

    $this->journalConfigurations = $journalConfigurations;

		$this->Gravatar = $Gravatar;

		$this->Carbon = $Carbon;

		$this->Lang = $Lang;

		$this->Config = $Config;

    //var_dump($journalConfigurations);
	}

	/**
	 * Get journals.
	 *
	 * @param array $post
	 * 	An array as follows: array('appId' = $appId, 'page' => $page, 'journalizedId' => $journalizedId, 'filter' => $filter, 'userId': userId, 'onlyActions': $onlyActions)
	 * @param boolean $returnArray
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  { page: $page, totalPages: $total, records: $records, start: $start, end: $end, pageRecords: $pageRecords, pagerPagesInfo: $pagerPagesInfo, pagerRecordsInfo: $pagerRecordsInfo, journalHeaders: [{ userImageSource: $userImageSource, formattedHeader: $formattedHeader, journalDetails: [ $detail1, $detail2,… ] }
	 */
	public function getJournalsByApp($post, $returnArray = false)
	{
		//$appConfiguration = $this->Config->get('journal.' . $post['appId']);

    $appConfiguration = $this->journalConfigurations[$post['appId']];

    if(!isset($post['organizationNotNull']))
    {
      $post['organizationNotNull'] = true;
    }

		return $this->getJournals($appConfiguration['journalizedType'], $appConfiguration['recordsPerPage'], $post['page'], $post['journalizedId'], $post['filter'], $post['userId'], $post['onlyActions'], null, $returnArray, $post['organizationNotNull']);
	}

  /**
   * Get journals.
   *
   * @param  string $journalizedType
   * @param  integer $limit
   * @param  integer $page
   * @param  integer $journalizedId
   * @param  string $filter
   * @param  int $userId
   * @param  boolean $onlyActions
   * @param  int $organizationId
   * @param  boolean $returnArray
   * @param  boolean $organizationNotNull
   *
   * @return JSON encoded string
   *  A string as follows:
   *  { page: $page, totalPages: $total, records: $records, start: $start, end: $end, pageRecords: $pageRecords, pagerPagesInfo: $pagerPagesInfo, pagerRecordsInfo: $pagerRecordsInfo, journalHeaders: [{ userImageSource: $userImageSource, formattedHeader: $formattedHeader, journalDetails: [ $detail1, $detail2,… ] }
   */
   public function getJournals($journalizedType, $limit, $page = 1, $journalizedId = null, $filter = null, $userId = null, $onlyActions = false, $organizationId = null, $returnArray = false, $organizationNotNull = true)
   {
    if(empty($organizationId))
		{
			$organizationId = $this->AuthenticationManager->getCurrentUserOrganization('id');
		}

		$count = $this->Journal->countJournalsByDynamicWhere($organizationId, $journalizedType, $journalizedId, $userId, $filter, $onlyActions, $organizationNotNull);

		if( $count > 0 )
		{
			$totalPages = ceil($count/$limit);
		}
		else
		{
			$totalPages = 0;
		}

		if ($page > $totalPages)
		{
			$page = $totalPages;
		}

		if ($limit < 0 )
		{
			$limit = 0;
		}

		$start = $limit * $page - $limit;

		if ($start < 0)
		{
			$start = 0;
		}

    $journalsHeader = $users = $journalsHeaderId = array();

    $tempJournalHeader = '';

    $tempJournalId = 0;

    $this->Journal->journalsHeaderByDynamicWhere($limit, $start, $organizationId, $journalizedType, $journalizedId, $userId, $filter, $onlyActions, $organizationNotNull)->each(function($Journal) use (&$journalsHeaderId)
    {
      array_push($journalsHeaderId, $Journal->id);
    });

    if(!empty($journalsHeaderId))
    {
  		$this->Journal->journalsByHeaderId($journalsHeaderId, $organizationId)->each(function($Journal) use (&$journalsHeader, &$tempJournalId, &$users, &$tempJournalHeader)
  		{
          if(!isset($users[$Journal->email]))
  	      {
            $users[$Journal->email] = array('userImageSource' => $this->Gravatar->buildGravatarURL($Journal->email, 30), 'userName' => $Journal->firstname . ' ' . $Journal->lastname);
  	      }

  	      if($tempJournalId == 0)
  	      {
  	        $tempJournalId = $Journal->id;

  	        $formattedHeader = $this->formatJournalHeader($Journal, $users);

  	        $tempJournalHeader = array('userImageSource' => $users[$Journal->email]['userImageSource'], 'formattedHeader' =>$formattedHeader, 'journalDetails' => array());
  	      }

  	      if($tempJournalId == $Journal->id)
  	      {
  	        array_push($tempJournalHeader['journalDetails'], $this->formatJournalDetail($Journal));
  	      }
  	      else
  	      {
  	        array_push($journalsHeader, $tempJournalHeader);

  	        $tempJournalId = $Journal->id;

  	        $formattedHeader = $this->formatJournalHeader($Journal, $users);

  	        $tempJournalHeader = array('userImageSource' => $users[$Journal->email]['userImageSource'], 'formattedHeader' =>$formattedHeader, 'journalDetails' => array());

  	        array_push($tempJournalHeader['journalDetails'], $this->formatJournalDetail($Journal));
  	      }
  		});
    }

    if(is_array($tempJournalHeader))
    {
    	array_push($journalsHeader, $tempJournalHeader);
    }

    $pageRecords = count($journalsHeader);

    $end = $start + $pageRecords;

    if($count > 0)
    {
      $start++;
    }

    $pagerPagesInfo = $this->Lang->get('journal.pagerPagesInfo', array('start' => $page, 'end' => $totalPages));

    $pagerRecordsInfo = $this->Lang->get('journal.pagerRecordsInfo', array('start' => $start, 'end' => $end, 'records' => $count));

    if($returnArray)
    {
      return array('page' => $page, 'totalPages' => $totalPages, 'records' => $count, 'start' => $start, 'end' => $end, 'pageRecords' => $pageRecords, 'pagerPagesInfo' => $pagerPagesInfo, 'pagerRecordsInfo' => $pagerRecordsInfo, 'journalHeaders' => $journalsHeader);
    }

    return json_encode(array('page' => $page, 'totalPages' => $totalPages, 'records' => $count, 'start' => $start, 'end' => $end, 'pageRecords' => $pageRecords, 'pagerPagesInfo' => $pagerPagesInfo, 'pagerRecordsInfo' => $pagerRecordsInfo, 'journalHeaders' => $journalsHeader));
	}

	/**
	 * Format details.
	 *
	 * @param  array $journalDetail
	 *
	 * @return string
	 */
	public function formatJournalDetail($Journal)
	{
		if(empty($Journal->note))
		{
      if(empty($Journal->old_value))
      {
        $oldValue = $this->Lang->get('journal.emptyValue');
      }
      else
      {
        $oldValue = $Journal->old_value;
      }

      if(empty($Journal->new_value))
      {
        $newValue = $this->Lang->get('journal.emptyValue');
      }
      else
      {
        $newValue = $Journal->new_value;
      }

			return $this->Lang->get('journal.journalDetail', array('field' => $this->Lang->get($Journal->field_lang_key), 'oldValue' => $oldValue, 'newValue' => $newValue));
		}

		return $Journal->note;
	}

	/**
	 * Format details.
	 *
	 * @param  array $journalDetail
	 * @param  array $users
	 *
	 * @return string
	 */
	public function formatJournalHeader($Journal, $users)
	{
		$timestamp = explode(' ', $this->Carbon->createFromFormat('Y-m-d H:i:s', $Journal->created_at, 'UTC')->setTimezone($this->AuthenticationManager->getLoggedUserTimeZone())->format($this->Lang->get('form.phpDateFormat')));

		$date = $timestamp[0];

		$time = $timestamp[1];

		if(isset($timestamp[2]))
		{
			$time = $timestamp[1] . ' ' . $timestamp[2];
		}

		return $this->Lang->get('journal.journalHeader', array('user' => $users[$Journal->email]['userName'], 'date' => $date, 'time' => $time));
	}


}

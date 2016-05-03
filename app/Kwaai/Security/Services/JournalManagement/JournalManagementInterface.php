<?php
/**
 * @file
 * Journal Management Interface.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Services\JournalManagement;

interface JournalManagementInterface {

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
	public function getJournalsByApp($post, $returnArray = false);

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
	*  {page: $page, totalPages: $total, records: $records, start: $start, end: $end, pageRecords: $pageRecords, pagerPagesInfo: $pagerPagesInfo, pagerRecordsInfo: $pagerRecordsInfo, journalHeaders: [{userImageSource: $userImageSource, formattedHeader: $formattedHeader, journalDetails: [ $detail1, $detail2,… ] }
	*/
	public function getJournals($journalizedType, $limit, $page = 1, $journalizedId = null, $filter = null, $userId = null, $onlyActions = false, $organizationId = null, $returnArray = false, $organizationNotNull = true);

}

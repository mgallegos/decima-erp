<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\Journal;

interface JournalInterface {

  /**
  * Create a new journal
  *
  * @param array $data
  * 	An array as follows: array('journalized_id'=>$journalizedId, 'journalized_type'=>$journalizeType, 'user_id'=>$userId)
  *
  * @return App\Kwaai\Security\Journal
  */
  public function create(array $data);

  /**
   * Count journals headers.
   *
   * @param  int $organizationId
   * @param  array $journalizedType
   * @param  array $journalizedId
   * @param  int $userId
   * @param  string $filter
   * @param  boolean $noteNotNull
   * @param  boolean $organizationNotNull
   *
   * @return integer
   */
  public function countJournalsByDynamicWhere($organizationId, $journalizedType = array(), $journalizedId = null, $userId = null, $filter = null, $noteNotNull = false, $organizationNotNull = true);

  /**
   * Get journals headers.
   *
   * @param  int $organizationId
   * @param  array $journalizedType
   * @param  array $journalizedId
   * @param  int $userId
   * @param  string $filter
   * @param  boolean $noteNotNull
   * @param  boolean $organizationNotNull
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function journalsHeaderByDynamicWhere($limit, $offset, $organizationId, $journalizedType = array(), $journalizedId = null, $userId = null, $filter = null, $noteNotNull = false, $organizationNotNull = true);

  /**
   * Get journals headers and details by journals header ID.
   *
   * @param  array $journalHeadersId
   * @param  int $organizationId
   * @param  array $journalizedType
   * @param  array $journalizedId
   * @param  int $userId
   * @param  string $filter
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function journalsByHeaderId($journalHeadersId, $organizationId);

  /**
   * Attach a new journal detail
   *
   * @param  int $journalId
   * @param array $detail
   *  An array as follows: array('field_lang_key' => $fieldLangKey, 'note' => $note, 'old_value' => $oldValue, 'new_value' => $newValue)
   * @param App\Kwaai\Security\Journal $Journal
   *
   * @return void
   */
  public function attachDetail($journalId, array $detail, $Journal = null);
}

<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Security\Repositories\Journal;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\DatabaseManager;

use Illuminate\Database\Eloquent\Model;

use App\Kwaai\Security\JournalDetail;

class EloquentJournal implements JournalInterface {

	/**
	 * Journal
	 *
	 * @var App\Kwaai\Security\Journal
	 *
	 */
    protected $Journal;

    /**
     * Journal
     *
     * @var App\Kwaai\Security\JournalDetail
     *
     */
    protected $JournalDetail;

    /**
     * DB
     *
     * @var Illuminate\Database\DatabaseManager
     *
     */
    protected $DB;

    public function __construct(Model $Journal, DatabaseManager $DB)
    {
        $this->Journal = $Journal;

        $this->DB = $DB;
    }

    /**
     * Get modules by ID
     *
     * @param  int $id
     *
     * @return App\Kwaai\Security\Module
     */
    /*public function byId($id)
    {
    	return $this->Module->find($id);
    }*/

    /**
     * Get all modules
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    /*public function all()
    {
    	return $this->Module->all();
    }*/

    /**
     * Create a new journal
     *
     * @param array $data
     * 	An array as follows: array('journalized_id'=>$journalizedId, 'journalized_type'=>$journalizeType, 'user_id'=>$userId)
     *
     * @return App\Kwaai\Security\Journal
     */
    public function create(array $data)
    {
      return $this->Journal->create($data);
    }

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
    public function countJournalsByDynamicWhere($organizationId, $journalizedType = array(), $journalizedId = null, $userId = null, $filter = null, $noteNotNull = false, $organizationNotNull = true)
    {
      $DB = $this->DB->table('SEC_Journal As j')
              ->select('j.id')
              ->groupBy('j.id')
              ->join('SEC_Journal_Detail AS jd', 'j.id', '=', 'jd.journal_id')
              ->join('SEC_User AS u', 'j.user_id', '=', 'u.id')
              ->where(function($query) use ($organizationId, $organizationNotNull)
                      {
                        $query->orWhere('j.organization_id', '=', $organizationId);

                        if(!$organizationNotNull)
                        {
                          $query->orWhereNull('j.organization_id');
                        }
                      }
				);

      if(!empty($journalizedType))
      {
        $DB->whereIn('j.journalized_type', $journalizedType);
      }

      if(!empty($journalizedId))
      {
      	$DB->where('j.journalized_id', '=', $journalizedId);
      }

      if(!empty($userId))
      {
        $DB->where('j.user_id', '=', $userId);
      }

      if(!empty($filter))
      {
        $filter = '%' . str_replace(' ', '%', $filter) . '%';

        $DB->where(function($query) use ($filter)
        {
          foreach (array('u.firstname', 'u.lastname', 'u.email', 'jd.field', 'jd.note', 'jd.old_value', 'jd.new_value', 'j.created_at') as $key => $value)
          {
            $query->orWhere($value, 'like', $filter);
          }
        });
      }

      if($noteNotNull)
      {
      	$DB->whereNotNull('jd.note');
      }

      $result = new Collection( $DB->get() );

      return $result->count();
    }

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
    public function journalsHeaderByDynamicWhere($limit, $offset, $organizationId, $journalizedType = array(), $journalizedId = null, $userId = null, $filter = null, $noteNotNull = false, $organizationNotNull = true)
    {
      $DB = $this->DB->table('SEC_Journal As j')
              ->select('j.id')
              ->groupBy('j.id')
              ->join('SEC_Journal_Detail AS jd', 'j.id', '=', 'jd.journal_id')
              ->join('SEC_User AS u', 'j.user_id', '=', 'u.id')
              ->where(function($query) use ($organizationId, $organizationNotNull)
                		  {
                		  	$query->orWhere('j.organization_id', '=', $organizationId);

                        if(!$organizationNotNull)
                        {
                          $query->orWhereNull('j.organization_id');
                        }
                      })
              ->orderBy('j.id', 'desc')
              ->take($limit)
              ->skip($offset);

      if(!empty($journalizedType))
      {
        $DB->whereIn('j.journalized_type', $journalizedType);
      }

      if(!empty($journalizedId))
      {
        $DB->where('j.journalized_id', '=', $journalizedId);
      }

      if(!empty($userId))
      {
        $DB->where('j.user_id', '=', $userId);
      }

      if(!empty($filter))
      {
      	$filter = '%' . str_replace(' ', '%', $filter) . '%';

        $DB->where(function($query) use ($filter)
        {
          foreach (array('u.firstname', 'u.lastname', 'u.email', 'jd.field', 'jd.note', 'jd.old_value', 'jd.new_value', 'j.created_at') as $key => $value)
    			{
    				$query->orWhere($value, 'like', $filter);
    			}
        });
      }

      if($noteNotNull)
      {
      	$DB->whereNotNull('jd.note');
      }

      return new Collection( $DB->get() );
    }

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
    public function journalsByHeaderId($journalHeadersId, $organizationId)
    {
      $DB = $this->DB->table('SEC_Journal As j')
              ->join('SEC_Journal_Detail AS jd', 'j.id', '=', 'jd.journal_id')
              ->join('SEC_User AS u', 'j.user_id', '=', 'u.id')
              ->where(function($query) use ($organizationId)
              		  {
                      $query->orWhere('j.organization_id', '=', $organizationId);
                      $query->orWhereNull('j.organization_id');
                    })
              ->whereIn('j.id', $journalHeadersId)
              ->orderBy('j.id', 'desc');

      return new Collection($DB->get(array('j.id', 'j.created_at', 'u.email', 'u.firstname', 'u.lastname', 'jd.note', 'jd.field_lang_key', 'jd.old_value', 'jd.new_value')));
    }

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
    public function attachDetail($journalId, array $detail, $Journal = null)
    {
      if(empty($Journal))
      {
        $Journal = $this->Journal->find($journalId);
      }

      $Journal->details()->save(new JournalDetail($detail));
    }
}

<?php
/**
 * @file
 * Handle user events.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Organization\EventsHandler;

use Illuminate\Queue\QueueManager;

use Illuminate\Http\Request;

use Illuminate\Log\Writer;

class Subscriber {

	/**
	 * Laravel Writer (Log)
	 *
	 * @var Illuminate\Log\Writer
	 *
	 */
	protected $Log;

	/**
	 * Laravel Request
	 *
	 * @var \Illuminate\Http\Request
	 *
	 */
	protected $Input;

	/**
	 * Laravel Queue
	 *
	 * @var Illuminate\Queue\QueueManager
	 *
	 */
	protected $Queue;

	public function __construct(Writer $Log, Request $Input, QueueManager $Queue)
	{
		$this->Log = $Log;

		$this->Input = $Input;

		$this->Queue = $Queue;
	}


	/**
	 * Handle user add operation events.
	 */
	public function onOrganizationAdded()
	{
		//$this->Log->notice('[ORGANIZATION EVENT] A new organization has been added to the system', array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all()));
		$this->Queue->push('App\Kwaai\Helpers\LogHandler@notice', array('message' => '[ORGANIZATION EVENT] A new organization has been added to the system', 'context' => array('post' => $this->Input->all(), 'json-post' => $this->Input->json()->all())));
	}


	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param  Illuminate\Events\Dispatcher  $events
	 *
	 * @return array
	 */
	public function subscribe($events)
	{
		$events->listen('organization.add', 'App\Kwaai\Organization\EventsHandler\Subscriber@onOrganizationAdded');
	}

}

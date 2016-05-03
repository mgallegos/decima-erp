<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

class OnNewInfoMessage extends Event
{
  use SerializesModels;

  /**
	 * Data
	 *
	 * @var Array
	 *
	 */
  public $data;

  /**
	 * Authentication Management Interface
	 *
	 * @var App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface
	 *
	 */
	protected $AuthenticationManager;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(Array $data, AuthenticationManagementInterface $AuthenticationManager)
  {
      $data['context']['tags'] = array('decimauser' => $AuthenticationManager->getLoggedUserEmail(), 'organization' => $AuthenticationManager->getCurrentUserOrganizationName());

      $this->data = $data;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn()
  {
      return [];
  }
}

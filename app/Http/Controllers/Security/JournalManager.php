<?php
/**
 * @file
 * Login controller.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;

use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface;

use App\Http\Controllers\Controller;

class JournalManager extends Controller {

	/**
	 * Journal Manager
	 *
	 * @var lluminate\Foundation\Application
	 *
	 */
	protected $JournalManager;

	/**
	 * Input
	 *
	 * @var Illuminate\Http\Request
	 *
	 */
	protected $Input;

	public function __construct(JournalManagementInterface $JournalManager, Request $Input)
	{
		$this->JournalManager = $JournalManager;

		$this->Input = $Input;
	}

	/**
	 * Handle a POST request to get journals of an application.
	 *
	 * @return Response
	 */
	public function postJournals()
	{
		return $this->JournalManager->getJournalsByApp( $this->Input->json()->all() );
	}
}

<?php
/**
 * @file
 * Initial Acounting Setup Controller.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Controllers;

use Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManagementInterface;

use Illuminate\View\Factory;

use Illuminate\Http\Request;

use Illuminate\Session\SessionManager;

use Illuminate\Translation\Translator;

use App\Http\Controllers\Controller;

class BalanceSheetManager extends Controller {

	/**
	 * Journal Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManagementInterface
	 *
	 */
	protected $JournalManagerService;

	/**
	 * Organization Manager Service
	 *
	 * @var App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManagementInterface
	 *
	 */
	//protected $OrganizationManagerService;

	/**
	 * View
	 *
	 * @var Illuminate\View\Factory
	 *
	 */
	protected $View;

	/**
	 * Input
	 *
	 * @var Illuminate\Http\Request
	 *
	 */
	protected $Input;

	/**
	 * Session
	 *
	 * @var Illuminate\Session\SessionManager
	 *
	 */
	protected $Session;

	/**
   * Laravel Translator instance
   *
   * @var Illuminate\Translation\Translator
   *
   */
  protected $Lang;

	public function __construct(JournalManagementInterface $JournalManagerService, Factory $View, Request $Input, SessionManager $Session, Translator $Lang)
	{
		$this->JournalManagerService = $JournalManagerService;

		//$this->OrganizationManagerService = $OrganizationManagerService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;

		$this->Lang = $Lang;
	}

	public function getIndex()
	{
		return $this->View->make('decima-accounting::balance-sheet')
						->with('currentDate', date($this->Lang->get('form.phpShortDateFormat')))
						->with('currentYear', date('Y'))
						->with('currentDateBd', date('Y-m-d'));
	}


	public function postBalanceSheetGridData()
	{
		return $this->JournalManagerService->getBalanceSheetGridData( $this->Input->all() );
	}
}

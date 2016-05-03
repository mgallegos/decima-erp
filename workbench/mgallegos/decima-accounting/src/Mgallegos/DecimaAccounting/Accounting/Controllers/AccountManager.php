<?php
/**
 * @file
 * Account Manager Controller.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Controllers;

use Illuminate\Session\SessionManager;

use Illuminate\Http\Request;

use Mgallegos\DecimaAccounting\Accounting\Services\AccountManagement\AccountManagementInterface;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class AccountManager extends Controller {

	/**
	 * Account Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\AccountManagement\AccountManagementInterface
	 *
	 */
	protected $AccountManagerService;

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

	public function __construct(AccountManagementInterface $AccountManagerService, Factory $View, Request $Input, SessionManager $Session)
	{
		$this->AccountManagerService = $AccountManagerService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;
	}

	public function getIndex()
	{
		return $this->View->make('decima-accounting::account-management')
						->with('newAccountAction', $this->Session->get('newAccountAction', false))
						->with('editAccountAction', $this->Session->get('editAccountAction', false))
						->with('deleteAccountAction', $this->Session->get('deleteAccountAction', false))
						->with('accounts', $this->AccountManagerService->getGroupsAccounts())
						->with('balanceTypes', $this->AccountManagerService->getBalanceTypes())
						->with('acountTypes', $this->AccountManagerService->getAccountsTypes());
	}

	public function postAccountGridData()
	{
		return $this->AccountManagerService->getAccountGridData( $this->Input->all() );
	}

	public function postCreate()
	{
		return $this->AccountManagerService->create( $this->Input->json()->all() );
	}

	public function postUpdate()
	{
		return $this->AccountManagerService->update( $this->Input->json()->all() );
	}

	public function postDelete()
	{
		return $this->AccountManagerService->delete( $this->Input->json()->all() );
	}

	public function postAccountChildren()
	{
		return $this->AccountManagerService->getAccountChildren( $this->Input->json()->all() );
	}

	public function postAccountChildrenIds()
	{
		return $this->AccountManagerService->getAccountChildrenIdsJson( $this->Input->json()->all());
	}


}

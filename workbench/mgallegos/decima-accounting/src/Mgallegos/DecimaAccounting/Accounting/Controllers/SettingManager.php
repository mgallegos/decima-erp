<?php
/**
 * @file
 * Initial Acounting Setup Controller.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\Accounting\Controllers;

use Illuminate\Session\SessionManager;

use Illuminate\Http\Request;

use Mgallegos\DecimaAccounting\Accounting\Services\SettingManagement\SettingManagementInterface;

use Illuminate\View\Factory;

use App\Http\Controllers\Controller;

class SettingManager extends Controller {

	/**
	 * Setting Manager Service
	 *
	 * @var Mgallegos\DecimaAccounting\Accounting\Services\SettingManagement\SettingManagementInterface
	 *
	 */
	protected $SettingManagerService;

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

	public function __construct(SettingManagementInterface $SettingManagerService, Factory $View, Request $Input, SessionManager $Session)
	{
		$this->SettingManagerService = $SettingManagerService;

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;
	}

	public function getIndex()
	{
		return $this->View->make('decima-accounting::initial-accounting-setup')
						->with('years', $this->SettingManagerService->getYears())
						->with('journals', $this->SettingManagerService->getSettingJournals())
						->with('accountsChartsTypes', $this->SettingManagerService->getCountryAccountsChartsTypes())
						->with('currentSettingConfiguration', $this->SettingManagerService->getCurrentSettingConfiguration());
	}

	public function postUpdateSettings()
	{
		return $this->SettingManagerService->updateAccountingSettings( $this->Input->json()->all() );
	}

	/*
	public function postStoreOrganization()
	{
		return $this->OrganizationManagerService->save( $this->Input->json()->all() );
	}*/
}

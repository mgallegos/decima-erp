<?php

/**
 * @file
 * Application Routes.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('middleware' => array('auth', 'check.first.time.access', 'check.access', 'csrf'), 'prefix' => 'accounting/setup'), function()
{
	Route::controller('/initial-accounting-setup', 'Mgallegos\DecimaAccounting\Accounting\Controllers\SettingManager');
});

Route::group(array('middleware' => array('auth'), 'prefix' => 'accounting'), function()
{
	Route::group(array('prefix' => '/setup'), function()
	{
		Route::get('/accounts-management/new', function()
		{
			return Redirect::to('accounting/setup/accounts-management')->with('newAccountAction', true);
		});

		Route::get('/accounts-management/edit', function()
		{
			return Redirect::to('accounting/setup/accounts-management')->with('editAccountAction', true);
		});

		Route::get('/accounts-management/delete', function()
		{
			return Redirect::to('accounting/setup/accounts-management')->with('deleteAccountAction', true);
		});

		Route::get('/cost-centers-management/new', function()
		{
			return Redirect::to('accounting/setup/cost-centers-management')->with('newCostCenterAction', true);
		});

		Route::get('/cost-centers-management/edit', function()
		{
			return Redirect::to('accounting/setup/cost-centers-management')->with('editCostCenterAction', true);
		});

		Route::get('/cost-centers-management/delete', function()
		{
			return Redirect::to('accounting/setup/cost-centers-management')->with('deleteCostCenterAction', true);
		});

		Route::get('/period-management/open', function()
		{
			return Redirect::to('accounting/setup/period-management')->with('openPeriodAction', true);
		});

		Route::get('/period-management/close', function()
		{
			return Redirect::to('accounting/setup/period-management')->with('closePeriodAction', true);
		});

		Route::group(array('middleware' => array('check.first.time.access', 'check.access', 'check.accounting.setup', 'csrf')), function()
		{
			Route::controller('/accounts-management', 'Mgallegos\DecimaAccounting\Accounting\Controllers\AccountManager');

			Route::controller('/cost-centers-management', 'Mgallegos\DecimaAccounting\Accounting\Controllers\CostCenterManager');

			Route::controller('/period-management', 'Mgallegos\DecimaAccounting\Accounting\Controllers\PeriodManager');
		});
	});

	Route::group(array('prefix' => '/transactions'), function()
	{
		Route::get('/journal-management/new', function()
		{
			return Redirect::to('accounting/transactions/journal-management')->with('newAccountingEntryAction', true);
		});

		Route::get('/journal-management/edit', function()
		{
			return Redirect::to('accounting/transactions/journal-management')->with('editAccountingEntryAction', true);
		});

		Route::get('/journal-management/nulify', function()
		{
			return Redirect::to('accounting/transactions/journal-management')->with('nulifyAccountingEntryAction', true);
		});

		Route::group(array('middleware' => array('check.first.time.access', 'check.access', 'check.accounting.setup', 'csrf')), function()
		{
			Route::controller('/journal-management', 'Mgallegos\DecimaAccounting\Accounting\Controllers\JournalManager');

			Route::controller('/close-fiscal-year', 'Mgallegos\DecimaAccounting\Accounting\Controllers\FiscalYearManager');
		});
	});

	Route::group(array('middleware' => array('check.first.time.access', 'check.access', 'check.accounting.setup', 'csrf'), 'prefix' => '/reports'), function()
	{
		Route::controller('/general-ledger', 'Mgallegos\DecimaAccounting\Accounting\Controllers\GeneralLedgerManager');

		Route::controller('/trial-balance', 'Mgallegos\DecimaAccounting\Accounting\Controllers\TrialBalanceManager');

		Route::controller('/balance-sheet', 'Mgallegos\DecimaAccounting\Accounting\Controllers\BalanceSheetManager');

		Route::controller('/profit-and-loss', 'Mgallegos\DecimaAccounting\Accounting\Controllers\ProfitAndLossManager');
	});
});

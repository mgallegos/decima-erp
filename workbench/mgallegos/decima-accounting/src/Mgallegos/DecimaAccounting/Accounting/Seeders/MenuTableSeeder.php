<?php
/**
 * @file
 * SEC_User Table Seeder
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
namespace Mgallegos\DecimaAccounting\Accounting\Seeders;

use DB;
use App\Kwaai\Security\Module;
use App\Kwaai\Security\Menu;
use App\Kwaai\Security\Permission;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder {

	public function run()
	{
		Module::create(array('name' => 'Accounting', 'lang_key' => 'decima-accounting::menu.accountingModule', 'icon' => 'fa fa-calculator', 'created_by' => 1));
		$accountingModuleId = DB::table('SEC_Module')->max('id');

		Menu::create(array('name' => 'Setup', 'lang_key' => 'decima-accounting::menu.setup', 'url' => null, 'icon' => 'fa fa-gear', 'parent_id' => null, 'module_id' => $accountingModuleId, 'created_by' => 1));

		$parentMenuId = DB::table('SEC_Menu')->max('id');

		Menu::create(array('name' => 'Initial Accounting Setup', 'lang_key' => 'decima-accounting::menu.initialAccountingSetup', 'url' => '/accounting/setup/initial-accounting-setup', 'action_button_id' => '', 'action_lang_key' => 'decima-accounting::menu.initialAccountingSetupAction', 'icon' => 'fa fa-gear', 'parent_id' => $parentMenuId, 'module_id' => $accountingModuleId, 'created_by' => 1));
		Menu::create(array('name' => 'Accounts Management', 'lang_key' => 'decima-accounting::menu.accountManagement', 'url' => '/accounting/setup/accounts-management', 'action_button_id' => 'acct-am-btn-close', 'action_lang_key' => 'decima-accounting::menu.accountManagementAction', 'icon' => 'fa fa-wrench', 'parent_id' => $parentMenuId, 'module_id' => $accountingModuleId, 'created_by' => 1));

		$lastMenuId = DB::table('SEC_Menu')->max('id');

		Permission::create(array('name' => 'New Account', 'key' => 'newAccount', 'lang_key' => 'decima-accounting::menu.newAccount', 'url' => '/accounting/setup/accounts-management/new', 'alias_url' => '/accounting/setup/accounts-management', 'action_button_id' => 'acct-am-btn-new', 'action_lang_key' => 'decima-accounting::menu.newAccountAction', 'icon' => 'fa fa-plus', 'is_only_shortcut' => true, 'menu_id' => $lastMenuId, 'created_by' => 1));
		Permission::create(array('name' => 'Edit Account', 'key' => 'editAccount', 'lang_key' => 'decima-accounting::menu.editAccount', 'url' => '/accounting/setup/accounts-management/edit', 'alias_url' => '/accounting/setup/accounts-management', 'action_button_id' => 'acct-am-btn-edit-helper', 'action_lang_key' => 'decima-accounting::menu.editAccountAction', 'is_only_shortcut' => true, 'menu_id' => $lastMenuId, 'created_by' => 1, 'hidden' => true));
		Permission::create(array('name' => 'Delete Account', 'key' => 'deleteAccount', 'lang_key' => 'decima-accounting::menu.deleteAccount', 'url' => '/accounting/setup/accounts-management/delete', 'alias_url' => '/accounting/setup/accounts-management', 'action_button_id' => 'acct-am-btn-delete-helper', 'action_lang_key' => 'decima-accounting::menu.deleteAccountAction', 'is_only_shortcut' => true, 'menu_id' => $lastMenuId, 'created_by' => 1, 'hidden' => true));

		Menu::create(array('name' => 'Cost Centers Management', 'lang_key' => 'decima-accounting::menu.costCentersManagement', 'url' => '/accounting/setup/cost-centers-management', 'action_button_id' => 'acct-ccm-btn-close', 'action_lang_key' => 'decima-accounting::menu.costCentersManagementAction', 'icon' => 'fa fa-wrench', 'parent_id' => $parentMenuId, 'module_id' => $accountingModuleId, 'created_by' => 1));

		$lastMenuId = DB::table('SEC_Menu')->max('id');

		Permission::create(array('name' => 'New Cost Center', 'key' => 'newCostCenter', 'lang_key' => 'decima-accounting::menu.newCostCenters', 'url' => '/accounting/setup/cost-centers-management/new', 'alias_url' => '/accounting/setup/cost-centers-management', 'action_button_id' => 'acct-ccm-btn-new', 'action_lang_key' => 'decima-accounting::menu.newCostCenterAction', 'icon' => 'fa fa-plus', 'is_only_shortcut' => true, 'menu_id' => $lastMenuId, 'created_by' => 1));
		Permission::create(array('name' => 'Edit Cost Center', 'key' => 'editCostCenter', 'lang_key' => 'decima-accounting::menu.editCostCenters', 'url' => '/accounting/setup/cost-centers-management/edit', 'alias_url' => '/accounting/setup/cost-centers-management', 'action_button_id' => 'acct-ccm-btn-edit-helper', 'action_lang_key' => 'decima-accounting::menu.editCostCenterAction', 'is_only_shortcut' => true, 'menu_id' => $lastMenuId, 'created_by' => 1, 'hidden' => true));
		Permission::create(array('name' => 'Delete Cost Center', 'key' => 'deleteCostCenter', 'lang_key' => 'decima-accounting::menu.deleteCostCenters', 'url' => '/accounting/setup/cost-centers-management/delete', 'alias_url' => '/accounting/setup/cost-centers-management', 'action_button_id' => 'acct-ccm-btn-delete-helper', 'action_lang_key' => 'decima-accounting::menu.deleteCostCenterAction', 'is_only_shortcut' => true, 'menu_id' => $lastMenuId, 'created_by' => 1, 'hidden' => true));

		Menu::create(array('name' => 'Periods Management', 'lang_key' => 'decima-accounting::menu.periodsManagement', 'url' => '/accounting/setup/period-management', 'action_button_id' => 'acct-pm-btn-close', 'action_lang_key' => 'decima-accounting::menu.periodsManagementAction', 'icon' => 'fa fa-wrench', 'parent_id' => $parentMenuId, 'module_id' => $accountingModuleId, 'created_by' => 1));

		$lastMenuId = DB::table('SEC_Menu')->max('id');

		Permission::create(array('name' => 'Open Period', 'key' => 'openPeriod', 'lang_key' => 'decima-accounting::menu.openPeriod', 'url' => '/accounting/setup/period-management/open', 'alias_url' => '/accounting/setup/period-management', 'action_button_id' => 'acct-pm-btn-open-helper', 'action_lang_key' => 'decima-accounting::menu.openPeriodAction', 'icon' => 'fa fa-folder-open-o', 'is_only_shortcut' => true, 'menu_id' => $lastMenuId, 'created_by' => 1));
		Permission::create(array('name' => 'Close Period', 'key' => 'closePeriod', 'lang_key' => 'decima-accounting::menu.closePeriod', 'url' => '/accounting/setup/period-management/close', 'alias_url' => '/accounting/setup/period-management', 'action_button_id' => 'acct-pm-btn-close-helper', 'action_lang_key' => 'decima-accounting::menu.closePeriodAction', 'icon' => 'fa fa-folder-o', 'is_only_shortcut' => true, 'menu_id' => $lastMenuId, 'created_by' => 1));

		Menu::create(array('name' => 'Transactions', 'lang_key' => 'decima-accounting::menu.transactions', 'url' => null, 'icon' => 'fa fa-exchange', 'parent_id' => null, 'module_id' => $accountingModuleId, 'created_by' => 1));

		$parentMenuId = DB::table('SEC_Menu')->max('id');

		Menu::create(array('name' => 'Journal Management', 'lang_key' => 'decima-accounting::menu.journalManagement', 'url' => '/accounting/transactions/journal-management', 'action_button_id' => 'acct-jm-btn-close', 'action_lang_key' => 'decima-accounting::menu.journalManagementAction', 'icon' => 'fa fa-wrench', 'parent_id' => $parentMenuId, 'module_id' => $accountingModuleId, 'created_by' => 1));

		$lastMenuId = DB::table('SEC_Menu')->max('id');

		Permission::create(array('name' => 'New Accounting Journal', 'key' => 'newAccountingEntry', 'lang_key' => 'decima-accounting::menu.newAccountingJournal', 'url' => '/accounting/transactions/journal-management/new', 'alias_url' => '/accounting/transactions/journal-management', 'action_button_id' => 'acct-jm-btn-new', 'action_lang_key' => 'decima-accounting::menu.newAccountingJournalAction', 'icon' => 'fa fa-plus', 'is_only_shortcut' => true, 'menu_id' => $lastMenuId, 'created_by' => 1));
		Permission::create(array('name' => 'Edit Accounting Journal', 'key' => 'editAccountingEntry', 'lang_key' => 'decima-accounting::menu.editAccountingJournal', 'url' => '/accounting/transactions/journal-management/edit', 'alias_url' => '/accounting/transactions/journal-management', 'action_button_id' => 'acct-jm-btn-edit-helper', 'action_lang_key' => 'decima-accounting::menu.editAccountingJournalAction', 'is_only_shortcut' => true, 'menu_id' => $lastMenuId, 'created_by' => 1, 'hidden' => true));
		Permission::create(array('name' => 'Nulify Accounting Journal', 'key' => 'nulifyAccountingEntry', 'lang_key' => 'decima-accounting::menu.nulifyAccountingJournal', 'url' => '/accounting/transactions/journal-management/nulify', 'alias_url' => '/accounting/transactions/journal-management', 'action_button_id' => 'acct-jm-btn-nulify-helper', 'action_lang_key' => 'decima-accounting::menu.nulifyAccountingJournalAction', 'is_only_shortcut' => true, 'menu_id' => $lastMenuId, 'created_by' => 1, 'hidden' => true));

		Menu::create(array('name' => 'Close a Fiscal Year', 'lang_key' => 'decima-accounting::menu.closeFiscalYear', 'url' => '/accounting/transactions/close-fiscal-year', 'action_button_id' => 'acct-cfy-btn-close', 'action_lang_key' => 'decima-accounting::menu.closeFiscalYearAction', 'icon' => 'fa fa-wrench', 'parent_id' => $parentMenuId, 'module_id' => $accountingModuleId, 'created_by' => 1));

		Menu::create(array('name' => 'Reports', 'lang_key' => 'decima-accounting::menu.reports', 'url' => null, 'icon' => 'fa fa-file-text', 'parent_id' => null, 'module_id' => $accountingModuleId, 'created_by' => 1));

		$parentMenuId = DB::table('SEC_Menu')->max('id');

		Menu::create(array('name' => 'General Ledger', 'lang_key' => 'decima-accounting::menu.generalLedger', 'url' => '/accounting/reports/general-ledger', 'action_button_id' => '', 'action_lang_key' => 'decima-accounting::menu.generalLedgerAction', 'icon' => 'fa fa-file-text-o', 'parent_id' => $parentMenuId, 'module_id' => $accountingModuleId, 'created_by' => 1));
		Menu::create(array('name' => 'Trial Balance', 'lang_key' => 'decima-accounting::menu.trialBalance', 'url' => '/accounting/reports/trial-balance', 'action_button_id' => '', 'action_lang_key' => 'decima-accounting::menu.trialBalanceAction', 'icon' => 'fa fa-file-text-o', 'parent_id' => $parentMenuId, 'module_id' => $accountingModuleId, 'created_by' => 1));
		Menu::create(array('name' => 'Balance Sheet', 'lang_key' => 'decima-accounting::menu.balanceSheet', 'url' => '/accounting/reports/balance-sheet', 'action_button_id' => '', 'action_lang_key' => 'decima-accounting::menu.balanceSheetAction', 'icon' => 'fa fa-file-text-o', 'parent_id' => $parentMenuId, 'module_id' => $accountingModuleId, 'created_by' => 1));
		Menu::create(array('name' => 'Profit and Loss', 'lang_key' => 'decima-accounting::menu.profitAndLoss', 'url' => '/accounting/reports/profit-and-loss', 'action_button_id' => '', 'action_lang_key' => 'decima-accounting::menu.profitAndLossAction', 'icon' => 'fa fa-file-text-o', 'parent_id' => $parentMenuId, 'module_id' => $accountingModuleId, 'created_by' => 1));
	}

}

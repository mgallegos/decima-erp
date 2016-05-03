<?php
/**
 * @file
 * SEC_User Table Seeder
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\System\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Mgallegos\DecimaAccounting\System\AccountType;

class AccountTypeTableSeeder extends Seeder {
//Categoria
// NInguno (no se hará incluido) -- A
// Pérdidas y Ganancias (Cuenta de ingresos) -- B
// Pérdidas y Ganancias (Cuenta de gastos) -- C
// Balance (Cuenta de activo)  -- D
// Balance (Cuenta de pasivo) -- E
// ---Cierre
// Ninguno (no se hará nada) -- F
// Saldo pendiente (normalmente se usará para cuentas de efectivo) -- G
// Detalle (copiará cada apunte del ejercicio anterior, incluso los conciliados) -- H
// No conciliado (copiará sólo los apuntes aun no conciliados, en el primer día del nuevo ejercicio fiscal) -- I



	public function run()
	{
		DB::table('SYS_Account_Type')->delete();

		AccountType::create(array('name' => 'Asset', 'key' => 'A', 'pl_bs_category' => 'D', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.asset'));
		AccountType::create(array('name' => 'Liability', 'key' => 'P', 'pl_bs_category' => 'E', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.liability'));
		AccountType::create(array('name' => 'Equity', 'key' => 'K', 'pl_bs_category' => 'E', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.equity'));
		AccountType::create(array('name' => 'Costs', 'key' => 'C', 'pl_bs_category' => 'C', 'deferral_method' => 'F', 'lang_key' => 'decima-accounting::account-type.costs'));
		AccountType::create(array('name' => 'Expense', 'key' => 'G', 'pl_bs_category' => 'C', 'deferral_method' => 'F', 'lang_key' => 'decima-accounting::account-type.expense'));
		AccountType::create(array('name' => 'Operating Revenues', 'key' => 'I', 'pl_bs_category' => 'B', 'deferral_method' => 'F', 'lang_key' => 'decima-accounting::account-type.operatingRevenues'));
		AccountType::create(array('name' => 'Other Revenues', 'key' => 'Y', 'pl_bs_category' => 'B', 'deferral_method' => 'F', 'lang_key' => 'decima-accounting::account-type.otherRevenues'));
		AccountType::create(array('name' => 'Closed Accounts', 'key' => 'L', 'pl_bs_category' => 'E', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.closedAccounts'));
		AccountType::create(array('name' => 'Memoranda Receivable Accounts', 'key' => 'O', 'pl_bs_category' => 'D', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.memorandaReceivableAccounts'));
		AccountType::create(array('name' => 'Memoranda Payable Accounts', 'key' => 'Q', 'pl_bs_category' => 'E', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.memorandaPayableAccounts'));

		// AccountType::create(array('name' => 'Asset', 'key' => 'A', 'pl_bs_category' => 'D', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.asset'));
		// AccountType::create(array('name' => 'Bank', 'key' => 'B', 'pl_bs_category' => 'D', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.bank'));
		// AccountType::create(array('name' => 'Cash', 'key' => 'C', 'pl_bs_category' => 'D', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.cash'));
		// AccountType::create(array('name' => 'Check', 'key' => 'D', 'pl_bs_category' => 'D', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.check'));
		// AccountType::create(array('name' => 'Equity', 'key' => 'E', 'pl_bs_category' => 'E', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.equity'));
		// AccountType::create(array('name' => 'Expense', 'key' => 'F', 'pl_bs_category' => 'C', 'deferral_method' => 'F', 'lang_key' => 'decima-accounting::account-type.expense'));
		// AccountType::create(array('name' => 'Income', 'key' => 'G', 'pl_bs_category' => 'B', 'deferral_method' => 'F', 'lang_key' => 'decima-accounting::account-type.income'));
		// AccountType::create(array('name' => 'Liability', 'key' => 'H', 'pl_bs_category' => 'E', 'deferral_method' => 'G', 'lang_key' => 'decima-accounting::account-type.liability'));
		// AccountType::create(array('name' => 'Payable', 'key' => 'I', 'pl_bs_category' => 'E', 'deferral_method' => 'I', 'lang_key' => 'decima-accounting::account-type.payable'));
		// AccountType::create(array('name' => 'Receivable', 'key' => 'J', 'pl_bs_category' => 'D', 'deferral_method' => 'I', 'lang_key' => 'decima-accounting::account-type.receivable'));
		// AccountType::create(array('name' => 'Tax', 'key' => 'K', 'pl_bs_category' => 'C', 'deferral_method' => 'I', 'lang_key' => 'decima-accounting::account-type.tax'));
		//AccountType::create(array('name' => '', 'pl_bs_category' => '', 'deferral_method' => '', 'lang_key' => 'decima-accounting::account-type.'));
	}

}

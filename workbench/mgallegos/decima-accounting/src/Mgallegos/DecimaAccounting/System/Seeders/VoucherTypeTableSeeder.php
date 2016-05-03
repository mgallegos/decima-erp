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
use Mgallegos\DecimaAccounting\System\VoucherType;

class VoucherTypeTableSeeder extends Seeder {

	public function run()
	{
		DB::table('SYS_Voucher_Type')->delete();

		// VoucherType::create(array('name' => 'Cash', 'lang_key' => 'decima-accounting::voucher-type.cash'));
		// VoucherType::create(array('name' => 'Bank', 'lang_key' => 'decima-accounting::voucher-type.bank'));
		// VoucherType::create(array('name' => 'Check', 'lang_key' => 'decima-accounting::voucher-type.purchase'));
		// VoucherType::create(array('name' => 'Purchase', 'lang_key' => 'decima-accounting::voucher-type.sale'));
		// VoucherType::create(array('name' => 'Debit Note', 'lang_key' => 'decima-accounting::voucher-type.debitNote'));
		// VoucherType::create(array('name' => 'Credit Note', 'lang_key' => 'decima-accounting::voucher-type.creditNote'));
		// VoucherType::create(array('name' => 'Miscellaneous', 'lang_key' => 'decima-accounting::voucher-type.miscellaneous'));

		VoucherType::create(array('name' => 'Opening Entry', 'lang_key' => 'decima-accounting::voucher-type.openingEntry', 'key' => 'O'));
		VoucherType::create(array('name' => 'Daily', 'lang_key' => 'decima-accounting::voucher-type.daily'));
		VoucherType::create(array('name' => 'Adjustment', 'lang_key' => 'decima-accounting::voucher-type.adjustment'));
		VoucherType::create(array('name' => 'Settlement income accounts', 'lang_key' => 'decima-accounting::voucher-type.settlementIncomeAccounts'));
		VoucherType::create(array('name' => 'Closing Entry', 'lang_key' => 'decima-accounting::voucher-type.closingEntry', 'key' => 'C'));
	}

}

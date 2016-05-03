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
use Mgallegos\DecimaAccounting\System\AccountChartType;

class AccountChartTypeTableSeeder extends Seeder {

	public function run()
	{
		DB::table('SYS_Account_Chart_Type')->delete();

		AccountChartType::create(array('name' => 'Generic Catalog', 'url' => 'https://docs.google.com/spreadsheets/d/1m8QLQFTCbwhwkaO9xsapXQOIgnUZqT7WbaUzsfJuX9Q/edit?pli=1#gid=1100153676', 'lang_key' => 'decima-accounting::account-chart-type.genericCatalog'));//1
		AccountChartType::create(array('name' => 'NIIF Pymes', 'url' => 'https://docs.google.com/spreadsheets/d/13vtZ30DqFRBNA3sOJBxR49bNNZ_rEuiFfJ8wFw4aJN8/edit?usp=sharing', 'lang_key' => 'decima-accounting::account-chart-type.niffPymes', 'country_id' => 202));//2
		AccountChartType::create(array('name' => 'Personalizado', 'url' => '', 'lang_key' => 'decima-accounting::account-chart-type.custom'));//3
	}

}

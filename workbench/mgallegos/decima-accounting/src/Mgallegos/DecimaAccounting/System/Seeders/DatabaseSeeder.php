<?php
/**
 * @file
 * PHP Class to run the database seeds.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
namespace Mgallegos\DecimaAccounting\System\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('Mgallegos\DecimaAccounting\System\Seeders\AccountTypeTableSeeder');

		$this->call('Mgallegos\DecimaAccounting\System\Seeders\AccountChartTypeTableSeeder');

		$this->call('Mgallegos\DecimaAccounting\System\Seeders\VoucherTypeTableSeeder');

		$this->call('Mgallegos\DecimaAccounting\System\Seeders\AccountTableSeeder');

		$this->call('Mgallegos\DecimaAccounting\System\Seeders\AccountSlvTableSeeder');
	}

}

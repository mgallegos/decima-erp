<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\System\Repositories;

use App\Kwaai\System\Country;

use App\Kwaai\System\Currency;

use App\Kwaai\System\SlvSetting;

use Illuminate\Support\ServiceProvider;


class RepositoriesServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerCountryInterface();

		$this->registerCurrencyInterface();

		$this->registerSlvSettingInterface();
	}


	/**
	* Register the country interface instance.
	*
	* @return void
	*/
	protected function registerCountryInterface()
	{
		$this->app->bind('App\Kwaai\System\Repositories\Country\CountryInterface', function()
		{
			return new \App\Kwaai\System\Repositories\Country\EloquentCountry( new Country() );
		});
	}

	/**
	* Register the currency interface instance.
	*
	* @return void
	*/
	protected function registerCurrencyInterface()
	{
		$this->app->bind('App\Kwaai\System\Repositories\Currency\CurrencyInterface', function()
		{
			return new \App\Kwaai\System\Repositories\Currency\EloquentCurrency( new Currency() );
		});
	}

	/**
	* Register the SlvSetting interface instance.
	*
	* @return void
	*/
	protected function registerSlvSettingInterface()
	{
		$this->app->bind('App\Kwaai\System\Repositories\SlvSetting\SlvSettingInterface', function()
		{
			return new \App\Kwaai\System\Repositories\SlvSetting\EloquentSlvSetting( new SlvSetting() );
		});
	}

}

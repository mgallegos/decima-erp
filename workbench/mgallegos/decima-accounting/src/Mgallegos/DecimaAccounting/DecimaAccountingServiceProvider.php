<?php namespace Mgallegos\DecimaAccounting;

use Mgallegos\DecimaAccounting\System\AccountChartType;

use Mgallegos\DecimaAccounting\Accounting\Setting;

use Mgallegos\DecimaAccounting\Accounting\Triggers\NewOrganizationTrigger;

use Mgallegos\DecimaAccounting\Accounting\AccountType;

use Mgallegos\DecimaAccounting\System\AccountType as SystemAccountType;

use Mgallegos\DecimaAccounting\Accounting\VoucherType;

use Mgallegos\DecimaAccounting\System\VoucherType as SystemVoucherType;

use Mgallegos\DecimaAccounting\Accounting\Period;

use Mgallegos\DecimaAccounting\Accounting\FiscalYear;

use Mgallegos\DecimaAccounting\Accounting\Account;

use Mgallegos\DecimaAccounting\System\Account as SystemAccount;

use Mgallegos\DecimaAccounting\Accounting\CostCenter;

use Mgallegos\DecimaAccounting\Accounting\JournalVoucher;

use Mgallegos\DecimaAccounting\Accounting\JournalEntry;

use Mgallegos\DecimaAccounting\Accounting\Services\SettingManagement\SettingManager;

use Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManager;

use Mgallegos\DecimaAccounting\Accounting\Services\AccountManagement\AccountManager;

use Mgallegos\DecimaAccounting\Accounting\Services\CostCenterManagement\CostCenterManager;

use Mgallegos\DecimaAccounting\Accounting\Services\PeriodManagement\PeriodManager;

use Mgallegos\DecimaAccounting\Accounting\Services\FiscalYearManagement\FiscalYearManager;

use Carbon\Carbon;

use Illuminate\Support\ServiceProvider;

class DecimaAccountingServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	* Bootstrap any application services.
	*
	* @return void
	*/
	public function boot()
	{
		include __DIR__.'/../../routes.php';

		include __DIR__.'/../../helpers.php';

		$this->loadViewsFrom(__DIR__.'/../../views', 'decima-accounting');

		$this->loadTranslationsFrom(__DIR__.'/../../lang', 'decima-accounting');

		$this->publishes([
				__DIR__ . '/../../config/config.php' => config_path('accounting-general.php'),
		], 'config');

		$this->mergeConfigFrom(
				__DIR__ . '/../../config/config.php', 'accounting-general'
		);

		$this->publishes([
				__DIR__ . '/../../config/journal.php' => config_path('accounting-journal.php'),
		], 'config');

		$this->mergeConfigFrom(
				__DIR__ . '/../../config/journal.php', 'accounting-journal'
		);

		$this->publishes([
    __DIR__.'/../../migrations/' => database_path('/migrations')
		], 'migrations');

		$this->registerJournalConfiguration();

		$this->registerAccountChartTypeInterface();

		$this->registerSystemAccountTypeInterface();

		$this->registerSystemVoucherTypeInterface();

		$this->registerSettingInterface();

		$this->registerNewOrganizationTrigger();

		$this->registerAccountTypeInterface();

		$this->registerVoucherTypeInterface();

		$this->registerPeriodInterface();

		$this->registerFiscalYearInterface();

		$this->registerAccountInterface();

		$this->registerSystemAccountInterface();

		$this->registerCostCenterInterface();

		$this->registerCostCenterInterface();

		$this->registerJournalVoucherInterface();

		$this->registerJournalEntryInterface();

		$this->registerSettingManagementInterface();

		$this->registerAccountManagementInterface();

		$this->registerCostCenterManagementInterface();

		$this->registerPeriodManagementInterface();

		$this->registerJournalManagementInterface();

		$this->registerFiscalYearManagementInterface();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	* Register a new organization trigger.
	*
	* @return void
	*/
	protected function registerJournalConfiguration()
	{
		$journalConfiguration = $this->app->make('AppJournalConfigurations');

		$this->app->instance('AppJournalConfigurations', array_merge($journalConfiguration, $this->app['config']->get('accounting-journal')));
	}

	/**
	* Register an account chart type interface instance.
	*
	* @return void
	*/
	protected function registerAccountChartTypeInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\System\Repositories\AccountChartType\AccountChartTypeInterface', function()
		{
			return new \Mgallegos\DecimaAccounting\System\Repositories\AccountChartType\EloquentAccountChartType( new AccountChartType() );
		});
	}

	/**
	* Register a system account type interface instance.
	*
	* @return void
	*/
	protected function registerSystemAccountTypeInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\System\Repositories\AccountType\AccountTypeInterface', function()
		{
			return new \Mgallegos\DecimaAccounting\System\Repositories\AccountType\EloquentAccountType( new SystemAccountType() );
		});
	}

	/**
	* Register a system account type interface instance.
	*
	* @return void
	*/
	protected function registerSystemVoucherTypeInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\System\Repositories\VoucherType\VoucherTypeInterface', function()
		{
			return new \Mgallegos\DecimaAccounting\System\Repositories\VoucherType\EloquentVoucherType( new SystemVoucherType() );
		});
	}

	/**
	* Register a setting interface instance.
	*
	* @return void
	*/
	protected function registerSettingInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface', function($app)
		{
			$AuthenticationManager = $app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface');

			//var_dump($AuthenticationManager->getCurrentUserOrganizationConnection());die();

			return new \Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\EloquentSetting(new Setting(), $AuthenticationManager->getCurrentUserOrganizationConnection());
		});
	}

	/**
	* Register a new organization trigger.
	*
	* @return void
	*/
	protected function registerNewOrganizationTrigger()
	{
		$NewOrganizationTriggerArray = $this->app->make('NewOrganizationTriggerInterface');

		array_push($NewOrganizationTriggerArray, new NewOrganizationTrigger($this->app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface'), $this->app->make('url'), $this->app->make('translator')));

		$this->app->instance('NewOrganizationTriggerInterface', $NewOrganizationTriggerArray);
	}

	/**
	* Register an account type interface instance.
	*
	* @return void
	*/
	protected function registerAccountTypeInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType\AccountTypeInterface', function($app)
		{
			$AuthenticationManager = $app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface');

			return new \Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType\EloquentAccountType(new AccountType(), $AuthenticationManager->getCurrentUserOrganizationConnection());
		});
	}

	/**
	* Register a system account type interface instance.
	*
	* @return void
	*/
	protected function registerVoucherTypeInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Repositories\VoucherType\VoucherTypeInterface', function($app)
		{
			$AuthenticationManager = $app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface');

			return new \Mgallegos\DecimaAccounting\Accounting\Repositories\VoucherType\EloquentVoucherType(new VoucherType(), $AuthenticationManager->getCurrentUserOrganizationConnection());
		});
	}

	/**
	* Register a period interface instance.
	*
	* @return void
	*/
	protected function registerPeriodInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface', function($app)
		{
			$AuthenticationManager = $app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface');

			return new \Mgallegos\DecimaAccounting\Accounting\Repositories\Period\EloquentPeriod(new Period(), $app['db'], $AuthenticationManager->getCurrentUserOrganizationConnection());
		});
	}

	/**
	* Register a fiscal year interface instance.
	*
	* @return void
	*/
	protected function registerFiscalYearInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface', function($app)
		{
			$AuthenticationManager = $app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface');

			return new \Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\EloquentFiscalYear(new FiscalYear(), $AuthenticationManager->getCurrentUserOrganizationConnection());
		});
	}

	/**
	* Register an account interface instance.
	*
	* @return void
	*/
	protected function registerAccountInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Repositories\Account\AccountInterface', function($app)
		{
			$AuthenticationManager = $app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface');

			return new \Mgallegos\DecimaAccounting\Accounting\Repositories\Account\EloquentAccount(new Account(), $AuthenticationManager->getCurrentUserOrganizationConnection());
		});
	}

	/**
	* Register a system account interface instance.
	*
	* @return void
	*/
	protected function registerSystemAccountInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\System\Repositories\Account\AccountInterface', function()
		{
			return new \Mgallegos\DecimaAccounting\System\Repositories\Account\EloquentAccount( new SystemAccount() );
		});
	}

	/**
	* Register a cost center interface instance.
	*
	* @return void
	*/
	protected function registerCostCenterInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\CostCenterInterface', function($app)
		{
			$AuthenticationManager = $app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface');

			return new \Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\EloquentCostCenter(new CostCenter(), $AuthenticationManager->getCurrentUserOrganizationConnection());
		});
	}

	/**
	* Register a journal voucher interface instance.
	*
	* @return void
	*/
	protected function registerJournalVoucherInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\JournalVoucherInterface', function($app)
		{
			$AuthenticationManager = $app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface');

			return new \Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentJournalVoucher(new JournalVoucher(), $AuthenticationManager->getCurrentUserOrganizationConnection());
		});
	}

	/**
	* Register a journal entry interface instance.
	*
	* @return void
	*/
	protected function registerJournalEntryInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface', function($app)
		{
			$AuthenticationManager = $app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface');

			return new \Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\EloquentJournalEntry(new JournalEntry(), $app['db'], $AuthenticationManager->getCurrentUserOrganizationConnection());
		});
	}

	/**
	* Register a setting management interface instance.
	*
	* @return void
	*/
	protected function registerSettingManagementInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Services\SettingManagement\SettingManagementInterface', function($app)
		{
			return new SettingManager(
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface'),
				$app->make('Mgallegos\DecimaAccounting\System\Repositories\AccountChartType\AccountChartTypeInterface'),
				$app->make('App\Kwaai\System\Repositories\Currency\CurrencyInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType\AccountTypeInterface'),
				$app->make('Mgallegos\DecimaAccounting\System\Repositories\AccountType\AccountTypeInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\Account\AccountInterface'),
				$app->make('Mgallegos\DecimaAccounting\System\Repositories\Account\AccountInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\VoucherType\VoucherTypeInterface'),
				$app->make('Mgallegos\DecimaAccounting\System\Repositories\VoucherType\VoucherTypeInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\CostCenterInterface'),
				$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
				$app->make('App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface'),
				$app->make('App\Kwaai\Security\Repositories\Journal\JournalInterface'),
				$app['db'],
				$app['translator'],
				$app['config']
			);
		});
	}

	/**
	* Register a account management interface instance.
	*
	* @return void
	*/
	protected function registerAccountManagementInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Services\AccountManagement\AccountManagementInterface', function($app)
		{
			return new AccountManager(
				$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
				$app->make('App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface'),
				$app->make('App\Kwaai\Security\Repositories\Journal\JournalInterface'),
				new	\Mgallegos\LaravelJqgrid\Encoders\JqGridJsonEncoder($app->make('excel')),
				new	\Mgallegos\DecimaAccounting\Accounting\Repositories\Account\EloquentAccountGridRepository(
					$app['db'],
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app['translator']
				),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\Account\AccountInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType\AccountTypeInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface'),
				new Carbon(),
				$app['db'],
				$app['translator'],
				$app['config']
			);
		});
	}

	/**
	* Register a account management interface instance.
	*
	* @return void
	*/
	protected function registerCostCenterManagementInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Services\CostCenterManagement\CostCenterManagementInterface', function($app)
		{
			return new CostCenterManager(
				$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
				$app->make('App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface'),
				$app->make('App\Kwaai\Security\Repositories\Journal\JournalInterface'),
				new	\Mgallegos\LaravelJqgrid\Encoders\JqGridJsonEncoder($app->make('excel')),
				new	\Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\EloquentCostCenterGridRepository(
					$app['db'],
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app['translator']
				),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\CostCenterInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface'),
				new Carbon(),
				$app['db'],
				$app['translator'],
				$app['config']
			);
		});
	}

	/**
	* Register a period management interface instance.
	*
	* @return void
	*/
	protected function registerPeriodManagementInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Services\PeriodManagement\PeriodManagementInterface', function($app)
		{
			return new PeriodManager(
				$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
				$app->make('App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface'),
				$app->make('App\Kwaai\Security\Repositories\Journal\JournalInterface'),
				new	\Mgallegos\LaravelJqgrid\Encoders\JqGridJsonEncoder($app->make('excel')),
				new	\Mgallegos\DecimaAccounting\Accounting\Repositories\Period\EloquentPeriodGridRepository(
					$app['db'],
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app['translator']
				),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\JournalVoucherInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface'),
				new Carbon(),
				$app['db'],
				$app['translator'],
				$app['config']
			);
		});
	}

	/**
	* Register a journal management interface instance.
	*
	* @return void
	*/
	protected function registerJournalManagementInterface()
	{

		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManagementInterface', function($app)
		{
			return new JournalManager(
				$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
				$app->make('App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Services\SettingManagement\SettingManagementInterface'),
				$app->make('App\Kwaai\Security\Repositories\Journal\JournalInterface'),
				new	\Mgallegos\LaravelJqgrid\Encoders\JqGridJsonEncoder($app->make('excel')),
				new	\Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentJournalVoucherGridRepository(
					$app['db'],
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app['translator']
				),
				new	\Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\EloquentJournalEntryGridRepository(
					$app['db'],
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface')
				),
				new	\Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentBalanceSheetGridRepository(
					$app['db'],
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app['translator']
				),
				new	\Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentProfitAndLossGridRepository(
					$app['db'],
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app['translator']
				),
				new	\Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentTrialBalanceGridRepository(
					$app['db'],
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app['translator'],
					new Carbon()
				),
				new	\Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\EloquentGeneralLedgerGridRepository(
					$app['db'],
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app->make('Mgallegos\DecimaAccounting\Accounting\Services\AccountManagement\AccountManagementInterface'),
					$app['translator'],
					new Carbon()
				),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\JournalVoucher\JournalVoucherInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\VoucherType\VoucherTypeInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\Account\AccountInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\CostCenter\CostCenterInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface'),
				/*
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\Setting\SettingInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\AccountType\AccountTypeInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\Period\PeriodInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\VoucherType\VoucherTypeInterface'),
				*/
				new Carbon(),
				$app['db'],
				$app['translator'],
				$app['config']
			);
		});
	}

	/**
	* Register a Fiscal Year management interface instance.
	*
	* @return void
	*/
	protected function registerFiscalYearManagementInterface()
	{
		$this->app->bind('Mgallegos\DecimaAccounting\Accounting\Services\FiscalYearManagement\FiscalYearManagementInterface', function($app)
		{
			return new FiscalYearManager(
				$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
				$app->make('App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Services\JournalManagement\JournalManagementInterface'),
				$app->make('App\Kwaai\Security\Repositories\Journal\JournalInterface'),
				new	\Mgallegos\LaravelJqgrid\Encoders\JqGridJsonEncoder($app->make('excel')),
				new	\Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\EloquentFiscalYearGridRepository(
					$app['db'],
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app['translator']
				),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\FiscalYear\FiscalYearInterface'),
				$app->make('Mgallegos\DecimaAccounting\Accounting\Repositories\JournalEntry\JournalEntryInterface'),
				new Carbon(),
				$app['db'],
				$app['translator'],
				$app['config']
			);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}

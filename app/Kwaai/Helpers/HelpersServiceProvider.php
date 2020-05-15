<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Helpers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 *
	 * @return void
	 */
	public function register()
	{

		$this->registerGravatar();

		$this->registerFormJavascript();

		$this->registerTranslator();

		$this->registerRegex();

		$this->registerLogHandler();

	}

	/**
	 * Register the Gravatar instance.
	 *
	 * @return void
	 */
	protected function registerGravatar()
	{
		$this->app->bind('gravatar', function($app)
		{
			return new \App\Kwaai\Helpers\Gravatar(
				$app['cache'],
				$app['config']
			);
		});
	}

	/**
	 * Register the FormJavascript instance.
	 *
	 * @return void
	 */
	protected function registerFormJavascript()
	{
		$this->app->bind('formjavascript', function()
		{
			return new \App\Kwaai\Helpers\FormJavascript;
		});
	}

	/**
	 * Register the Translation instance.
	 *
	 * @return void
	 */
	protected function registerTranslator()
	{
		$this->app->bind('apptranslator', function($app)
		//$this->app['apptranslator'] = $this->app->share(function($app)
		{
			$loader = $app['translation.loader'];

			// When registering the translator component, we'll need to set the default
			// locale as well as the fallback locale. So, we'll grab the application
			// configuration so we can easily get both of these values from there.
			$locale = $app['config']['app.locale'];

			return new \App\Kwaai\Helpers\Translator($loader, $locale);
		});
	}

	/**
	 * Register the Regex instance.
	 *
	 * @return void
	 */
	protected function registerRegex()
	{
		$this->app->bind('regex', function($app)
		{
			$locale = $app['config']['app.locale'];

			return new \App\Kwaai\Helpers\Regex($locale);
		});
	}

	/**
	* Register the Gravatar instance.
	*
	* @return void
	*/
	protected function registerLogHandler()
	{
		$this->app->bind('App\Kwaai\Helpers\LogHandler', function($app)
		{
			return new \App\Kwaai\Helpers\LogHandler($app['log'], $app['request']);
		});
	}
}

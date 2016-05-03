<?php

/**
 * @file
 * Application Routes.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

//var_dump(DB::table('SEC_Menu')->max('id'));//4
//var_dump(DB::table('SEC_Failed_Jobs')->max('id'));//4
/*$query_date = '2010-2-04';
$date = new DateTime($query_date);
//First day of month
$date->modify('first day of this month');
$firstday= $date->format('Y-m-d');
//Last day of month
$date->modify('last day of this month');
$lastday= $date->format('Y-m-d');
var_dump($firstday, $lastday);*/
//var_dump($app['AppJournalConfigurations']);

//var_dump(\Carbon\Carbon::createFromFormat('d/m/Y', '08/07/2015')->format('Y-m-d'));
//var_dump(date('2015-01-01'));
// var_dump(date('m'));
//http://carbon.nesbot.com/docs/
//$Date = new \Carbon\Carbon('first day of this month');
//$Date = new \Carbon\Carbon('first day of january');
//var_dump($Date->format('Y-m-d'));

//$url = $app['url'];
//var_dump(URL::to('/accounting/setup/initial-accounting-setup'));

/*
object(Maatwebsite\Excel\Collections\CellCollection)[4242]
  protected 'title' => null
  protected 'items' =>
    array (size=7)
      'id_del_estudiante' => string 'salarcon' (length=8)
      'nombre_del_estudiante' => string 'Alarcon BIB, Stephanie Geraldine' (length=32)
      'examen_semana_1_10' => float 8
      'examen_semana_2_10' => float 7
      'tarea_semana_3_10' => float 10
      'tarea_semana_4_10' => float 10
      'acumulativa' => float 87.5
string 'jjanaya' (length=7)
*/

// var_dump(explode('/', '10/03/2014'));

//var_dump($app->environment('gae'));

// var_dump(\Carbon\Carbon::createFromFormat('d/m/Y', '07/06/1985')->diff(\Carbon\Carbon::createFromFormat('d/m/Y', '06/06/2000'))->format('%y'));
// var_dump((int)\Carbon\Carbon::createFromFormat('d/m/Y', '07/06/1985')->diff(\Carbon\Carbon::createFromFormat('d/m/Y', '06/06/2000'))->format('%y'));
//var_dump(\Carbon\Carbon::createFromFormat('d/m/Y', 'NINGUNO'));
// try {
// 	\Carbon\Carbon::createFromFormat('d/m/Y', 'NINGUNO');
// } catch (Exception $e) {
// 	echo 'dead';
// }
//
// echo 'valid';
// var_dump(\Carbon\Carbon::createFromFormat('d/m/Y', '00/00/0000'));

// Log::info('Task completed', [
//     'tags' => ['state' => 1234]
// ]);
//
// $app = $this->app;
// $this->app['raven.handler']->log('info', 'Hello Sentry5!', array());

// $h = array('hello' => array('value' => 'hola'));
// var_dump(isset($h['hello']['value']));


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
View::composer('*', function($view)
{
	if(Request::getMethod() == 'GET')
	{
		$view->with('appInfo', AppManager::getAppInfo());
		$view->with('userOrganizations', UserManager::getUserOrganizations());
		$view->with('userAppPermissions', UserManager::getUserAppPermissions());
		$view->with('userActions', UserManager::getUserActions());
	}
});

Route::get('caslogout', 'Security\Logout@getCasLogoutAttempt');

Route::group(array('middleware' => array ('guest', 'check.browser', 'csrf')), function()
{
	if(Config::get('system-security.cas') && Cas::isAuthenticated())
	{
		Route::get('login', 'Security\Login@getCasAuthenticationAttempt');
	}
	else
	{
		Route::controller('login', 'Security\Login');
	}
});

Route::group(array('middleware' => array ('guest', 'csrf')), function()
{
	Route::get('/error', function()
	{
		return View::make('security/error')
						->with('error', Session::get('error', ''));
	});

	Route::get('password-reminder', 'Security\Reminder@getRemind');

	Route::post('password-reminder/remind', 'Security\Reminder@postRemind');

	Route::get('password-reset/{token}', 'Security\Reminder@getReset');

	Route::post('password-reminder/reset', 'Security\Reminder@postReset');

	Route::get('user-activation/{token}', 'Security\Reminder@getActivation');

	Route::post('user-activation/activate', 'Security\Reminder@postActivate');
});

Route::group(array('middleware' => array ('auth')), function()
{
	Route::group(array('middleware' => array('check.first.time.access')), function()
	{
		Route::get('/', function()
		{
			return View::make('dashboard')
						->with('organizationJournals', OrganizationManager::getOrganizationJournals());
		});

		Route::get('initial-setup', function()
		{
			return View::make('initial-setup')
					->withTimezones(UserManager::getTimezones());
		});

		Route::get('/user-preferences', 'Security\UserManager@getUserPreferencesIndex');
	});

	Route::controller('security/logout', 'Security\Logout');
});

Route::group(array('middleware' => array('auth'), 'prefix' => 'general-setup'), function()
{
	Route::group(array('prefix' => '/organization'), function()
	{
		Route::get('/organization-management/new', function()
		{
			return Redirect::to('general-setup/organization/organization-management')->with('newOrganizationAction', true);
		});

		Route::get('/organization-management/edit', function()
		{
			return Redirect::to('general-setup/organization/organization-management')->with('editOrganizationAction', true);
		});

		Route::get('/organization-management/remove', function()
		{
			return Redirect::to('general-setup/organization/organization-management')->with('removeOrganizationAction', true);
		});

		Route::group(array('middleware' => array('check.first.time.access', 'check.access', 'csrf')), function()
		{
			Route::controller('/organization-management', 'Organization\OrganizationManager');
		});
	});

	Route::group(array('middleware' => array('auth'), 'prefix' => '/security'), function()
	{
		Route::get('/user-management/new-admin', function()
		{
			return Redirect::to('general-setup/security/user-management')->with('newAdminUserAction', true);
		});

		Route::get('/user-management/new', function()
		{
			return Redirect::to('general-setup/security/user-management')->with('newUserAction', true);
		});

		Route::get('/user-management/remove-user', function()
		{
		return Redirect::to('general-setup/security/user-management')->with('removeUserAction', true);
		});

		Route::get('/user-management/assign-role', function()
		{
			return Redirect::to('general-setup/security/user-management')->with('assignRoleAction', true);
		});

		Route::get('/user-management/unassign-role', function()
		{
			return Redirect::to('general-setup/security/user-management')->with('unassignRoleAction', true);
		});

		Route::group(array('middleware' => array('check.first.time.access', 'check.access', 'csrf')), function()
		{
			Route::controller('/user-management', 'Security\UserManager');

			Route::controller('/journals-management', 'Security\JournalManager');
		});
	});
});

Route::post('tasks', array('as' => 'tasks', function()
{
    return Queue::marshal();
}));

/*App::missing(function($exception)
{
	Event::fire(new \App\Events\OnNewWarningMessage(array('message' => '[SECURITY EVENT] User tried to access a non-existent page', 'context' => array('extra' => ''))));
	return Redirect::to(AppManager::getErrorPageUrl())->withError(Lang::get('validation.pageNotFound'));
	//return Response::view('errors.missing', array(), 404);
});*/

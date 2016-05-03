<?php
/**
 * @file
 * Journals configuration config file.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

return array(

	/*
 	|--------------------------------------------------------------------------
	| User Manager App
	|--------------------------------------------------------------------------
	|
	*/
	'user-management' => array('journalizedType' => array('SEC_User'), 'recordsPerPage' => 4),

	/*
	|--------------------------------------------------------------------------
	| Organization Manager App
	|--------------------------------------------------------------------------
	|
	*/
	'organization-management' => array('journalizedType' => array('ORG_Organization'), 'recordsPerPage' => 4),

	/*
	|--------------------------------------------------------------------------
	| User Preference Page: actions journals
	|--------------------------------------------------------------------------
	|
	*/
	'user-preferences-actions' => array('journalizedType' => array(), 'recordsPerPage' => 2),

	/*
	|--------------------------------------------------------------------------
	| User Preference Page: actions journals
	|--------------------------------------------------------------------------
	|
	*/
	'user-preferences-changes' => array('journalizedType' => array('SEC_User'), 'recordsPerPage' => 2), 
	
	/*
	|--------------------------------------------------------------------------
	| Dashboard
	|--------------------------------------------------------------------------
	|
	*/
	'dashboard' => array('journalizedType' => array(), 'recordsPerPage' => 6),	


);

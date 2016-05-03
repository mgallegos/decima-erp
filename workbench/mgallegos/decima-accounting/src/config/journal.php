<?php
/**
 * @file
 * Journals configuration config file.
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

return array(

	/*
 	|--------------------------------------------------------------------------
	| Initial Accounting Setup Page
	|--------------------------------------------------------------------------
	|
	*/
	'acct-initial-acounting-setup' => array('journalizedType' => array('ACCT_Setting'), 'recordsPerPage' => 4),

	/*
 	|--------------------------------------------------------------------------
	| Journal Management App
	|--------------------------------------------------------------------------
	|
	*/
	'journal-management' => array('journalizedType' => array('ACCT_Journal_Voucher'), 'recordsPerPage' => 4),

	/*
 	|--------------------------------------------------------------------------
	| Account Management App
	|--------------------------------------------------------------------------
	|
	*/
	'accounts-management' => array('journalizedType' => array('ACCT_Account'), 'recordsPerPage' => 4),

	/*
 	|--------------------------------------------------------------------------
	| Cost Center Management App
	|--------------------------------------------------------------------------
	|
	*/
	'cost-centers-management' => array('journalizedType' => array('ACCT_Cost_Center'), 'recordsPerPage' => 4),

	/*
 	|--------------------------------------------------------------------------
	| Period Management App
	|--------------------------------------------------------------------------
	|
	*/
	'period-management' => array('journalizedType' => array('ACCT_Period'), 'recordsPerPage' => 4),

	/*
 	|--------------------------------------------------------------------------
	| Period Management App
	|--------------------------------------------------------------------------
	|
	*/
	'close-fiscal-year' => array('journalizedType' => array('ACCT_Fiscal_Year'), 'recordsPerPage' => 4),
);

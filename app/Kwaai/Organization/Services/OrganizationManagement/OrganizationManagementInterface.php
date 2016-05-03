<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Organization\Services\OrganizationManagement;

interface OrganizationManagementInterface {

	/**
	 * Echo organization grid data in a jqGrid compatible format
	 *
	 * @param array $post
	 *	All jqGrid posted data
	 *
	 * @return void
	 */
	public function getOrganizationGridData(array $post);

	/**
	 * Get system countries
	 *
	 * @return array
	 *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
	 */
	public function getSystemCountries();

	/**
	* Get system currencies
	*
	* @return array
	*  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
	*/
	public function getSystemCurrencies();

	/**
	* Get Dashboard Page Journals
	*
	* @return array
	*/
	public function getOrganizationJournals();

	/**
	* Get organization by id
	*
	* @return App\Kwaai\Organization\Organization
	*/
	public function getOrganizationById($id);

	/**
	* Get organization column by id
	*
	* @return App\Kwaai\Organization\Organization
	*/
	public function getOrganizationColumnById($id, $column = 'name');

	/**
	* Get organization currency symbol
	*
	* @return App\Kwaai\Organization\Organization
	*/
	public function getOrganizationCurrencySymbol($id);

	/**
	 * If user access this application for the first time, a welcome message should be shown.
	 *
	 * @return boolean
	 */
	public function showWelcomeMessage();

	/**
	 * If user is not root the "created by" column must be hidden.
	 *
	 * @return boolean
	 *	True if is user is not root, false otherwise
	 */
	public function hideCreatedByColumn();

	/**
	 * If user is administrator and does not have at least one organization associated, the form to create an organization must be shown.
	 *
	 * @return string
	 */
	public function requestUserToCreateOrganization();

	/**
	 * Create a new organization
	 *
	 * @param array $input
     * 	An array as follows: array('name'=>$name, 'street1'=>$street1, 'street2'=>$street2, 'zip_code'=>$zip_code, 'web_site'=>$web_site,
     * 							   'phone_number'=>$phone_number, 'fax'=>$fax, 'email'=>$email, 'tax_id'=>$tax_id, 'company_registration'=>$company_registration,
     * 							   'database_connection_name'=>$database_connection_name, 'country_id'=>$country_id, 'city_name'=>$city_name, 'state_name'=>$state_name
     * 						 );
     *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success and user has one organization: {"success" : form.defaultSuccessSaveMessage, "organizationName": $organizationName, "userApps" : [ { name: $moduleName, icon: $icon, childsMenus: [ { name: $menuName, url: $url, icon: $icon, childsMenus: [ { … },… ] },… ] },…]
	 *	In case of success and user has two organization: {"success" : form.defaultSuccessSaveMessage, "userOrganizations" : [{id: $organizationId0, name:$organizationName0}, {id: $organizationId1, name:$organizationName1}], organizationMenuLang: Lang::get('top-bar.userOrganizations')}
	 *  In case of success and user has three or more organization: {"success":form.defaultSuccessSaveMessage}
	 *  In case of database connection exception: {"info":organization/organization-management.databaseConnectionException}
	 */
	public function save(array $input);

	/**
	 * Update an existing organization
	 *
	 * @param array $input
	 * 	An array as follows: array('id'=>$id, 'name'=>$name, 'street1'=>$street1, 'street2'=>$street2, 'zip_code'=>$zip_code, 'web_site'=>$web_site,
	 * 							   'phone_number'=>$phone_number, 'fax'=>$fax, 'email'=>$email, 'tax_id'=>$tax_id, 'company_registration'=>$company_registration,
	 * 							   'country_id'=>$country_id, 'city_name'=>$city_name, 'state_name'=>$state_name
	 * 						 );
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessUpdateMessage}
	 *  In case of failure: {"failure":form.defaultErrorMessage}
	 */
	public function update(array $input);

	/**
	 * Delete existing organizations (soft delete)
	 *
	 * @param array $input
	 * 	An array as follows: array($id0, $id1,…);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessDeleteMessage}
	 *  In case of failure: {"failure":form.defaultErrorMessage}
	 */
	public function delete(array $input);
}

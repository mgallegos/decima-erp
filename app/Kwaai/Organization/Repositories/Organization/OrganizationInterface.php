<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Organization\Repositories\Organization;

interface OrganizationInterface {

  /**
    * Get table name
    *
    * @return string
    */
   public function getTable();

	/**
	 * Get all organizations
	 *
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function all();

	/**
	 * Retrieve organization by id
	 *
	 * @param  int $id Organization id
	 *
	 * @return App\Kwaai\Organization\Organization
	 */
	public function byId($id);

	/**
     * Create a new organization
     *
     * @param array $data
     * 	An array as follows: array('name'=>$name, 'street1'=>$street1, 'street2'=>$street2, 'zip_code'=>$zip_code, 'web_site'=>$web_site,
     * 							   'phone_number'=>$phone_number, 'fax'=>$fax, 'email'=>$email, 'tax_id'=>$tax_id, 'company_registration'=>$company_registration,
     * 							   'database_connection_name'=>$database_connection_name, 'country_id'=>$country_id, 'city_name'=>$city_name, 'state_name'=>$state_name, 'created_by'=>$created_by,
     * 						 );
     *
     * @return App\Kwaai\Organization\Organization
     */
    public function create(array $data);

  	/**
    * Update an existing organization
    *
    * @param array $data
    * 	An array as follows: array('id'=>$id, 'name'=>$name, 'street1'=>$street1, 'street2'=>$street2, 'zip_code'=>$zip_code, 'web_site'=>$web_site,
    * 							   'phone_number'=>$phone_number, 'fax'=>$fax, 'email'=>$email, 'tax_id'=>$tax_id, 'company_registration'=>$company_registration,
    * 							   'country_id'=>$country_id, 'city_name'=>$city_name, 'state_name'=>$state_name
    * 						 );
    * @param App\Kwaai\Security\Organization $Organization
    *
    * @return boolean
    */
   public function update(array $data, $Organization = null);

	/**
	 * Delete existing organizations (soft delete)
	 *
	 * @param array $data
	 * 	An array as follows: array($id0, $id1,…);
	 *
	 * @return boolean
	 */
	public function delete(array $data);

    /**
     * Retrieve organization's roles by organization' id
     *
     * @param  int $id Organization id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function rolesByOrganization($id);
}

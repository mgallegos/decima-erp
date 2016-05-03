<?php
/**
 * @file
 * Validation service interface.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
 
namespace App\Kwaai\System\Services\Validation;

interface ValidableInterface {

    /**
     * Add data to validation against
     *
     * @param array
     * @return \Impl\Service\Validation\ValidableInterface  $this
     */
    public function with(array $input);

    /**
     * Test if validation passes or fails
     *
     * @return boolean
     */
    public function passes();
    
    /**
     * Test if validation fails or passes
     *
     * @return boolean
     */
    public function fails();

    /**
     * Retrieve validation errors
     *
     * @return object
     */
    public function errors();
    
    /**
     * Organize an array with field and its corresponding validation message
     *
     * @return array
     */
    function singleMessageStringByField();

}
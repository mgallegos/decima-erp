<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Helpers;

class FormJavascript
{
	protected  $code='';

	public function getCode()
	{
	    return $this->code;
	}

	public function setCode($code)
	{
	    $this->code .= $code;
	}
}
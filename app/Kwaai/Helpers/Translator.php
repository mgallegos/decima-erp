<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Helpers;
use \Illuminate\Translation\Translator as LaravelTranslator;

class Translator extends LaravelTranslator
{
	public function __construct($loader, $locale) 
	{
		parent::__construct($loader, $locale);
	}
	
	/**
	 * Get the translation array for the given file.
	 *
	 * @param  string  $file
	 * @return array
	 */
	public function getFileArray($file)
	{			
		list($namespace, $group, $item) = $this->parseKey($file);
	
		$locale = $this->getLocale();
	
		$this->load($namespace, $group, $locale);
			
		return $this->loaded[$namespace][$group][$locale];
	}
}
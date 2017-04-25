<?php

/*
|--------------------------------------------------------------------------
| Integrating Sentry Logging
|--------------------------------------------------------------------------
|
*/

/**
 * @file
 * Custom system helpers
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

 if ( ! function_exists('eloquent_array_filter'))
 {
   /**
    * Removes empty string and null elements from an array
    *
    * @param  array  $array
    *
    * @return array
    */
   function eloquent_array_filter_for_insert($array)
   {
     return array_filter($array, function($a)
            {
                if(is_null($a))
                {
                  return false;
                }
                elseif (is_string($a) && trim($a) === "")
                // elseif (is_string($a) && (trim($a) === '' || trim($a) == ''  || trim($a) == ' ' || trim($a) == ' '))
                {
                  return false;
                }
                else
                {
                  return true;
                }
            });
   }
}

if ( ! function_exists('eloquent_array_filter'))
{
   /**
    * Removes null elements and converts empty string to null values from an array
    *
    * @param  array  $array
    *
    * @return array
    */
   function eloquent_array_filter_for_update($array)
   {
     return array_filter($array, function(&$a)
            {
                if(is_null($a))
                {
                  return false;
                }
                elseif (is_string($a) && (empty($a) || trim($a) === '' || trim($a) == ''  || trim($a) == ' ' || trim($a) == ' ' || trim($a) == '\xC2\xA0' || $a == ' ' || $a == ' ' || $a == ''))
                {
                  // return false;
                  $a = null;
                  return true;
                }
                else
                {
                  return true;
                }
            });
   }
 }

 if ( ! function_exists('remove_thousands_separator'))
 {
    /**
     * Remove thousands separator
     *
     * @param  string  $value
     *
     * @return string
     */
    function remove_thousands_separator($value)
    {
      return str_replace(Lang::get('form.thousandsSeparator'), '', $value);
    }
  }

  if ( ! function_exists('parse_jqgrid_filters'))
  {
    /**
     * R....
     *
     * @param  string  $value
     *
     * @return array
     */
    function parse_jqgrid_filters(&$filters)
    {
      foreach ($filters as &$filter)
			{
				switch ($filter['op'])
				{
					case 'eq': //equal
						$filter['op'] = '=';
						break;
					case 'ne': //not equal
						$filter['op'] = '!=';
						break;
					case 'lt': //less
						$filter['op'] = '<';
						break;
					case 'le': //less or equal
						$filter['op'] = '<=';
						break;
					case 'gt': //greater
						$filter['op'] = '>';
						break;
					case 'ge': //greater or equal
						$filter['op'] = '>=';
						break;
					case 'bw': //begins with
						$filter['op'] = 'like';
						$filter['data'] = $filter['data'] . '%';
						break;
					case 'bn': //does not begin with
						$filter['op'] = 'not like';
						$filter['data'] = $filter['data'] . '%';
						break;
					case 'in': //is in
						$filter['op'] = 'is in';
						break;
					case 'ni': //is not in
						$filter['op'] = 'is not in';
						break;
					case 'ew': //ends with
						$filter['op'] = 'like';
						$filter['data'] = '%' . $filter['data'];
						break;
					case 'en': //does not end with
						$filter['op'] = 'not like';
						$filter['data'] = '%' . $filter['data'];
						break;
					case 'cn': //contains
						$filter['op'] = 'like';
						$filter['data'] = '%' . $filter['data'] . '%';
						break;
					case 'nc': //does not contains
						$filter['op'] = 'not like';
						$filter['data'] = '%' . $filter['data'] . '%';
						break;
				}
			}
    }
  }

  if ( ! function_exists('getYears'))
  {
    /**
    * Get years
    *
    * @return array
    *  An array of arrays as follows: array($year0 => $year0, $year1 => $year1,… )
    */
    function getYears()
    {
      $years = array();

      foreach (range(date('Y'), 1950) as $x)
      {
        $years = array_add($years, $x, $x);
      }

      return $years;
    }
  }

  if ( ! function_exists('checkbox_journal_value'))
  {
    /**
     * R....
     *
     * @param  string  $value
     *
     * @return array
     */
    function checkbox_journal_value($value)
    {

    }
  }

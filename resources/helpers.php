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
                elseif (is_string($a) && (trim($a) === '' || trim($a) == ''  || trim($a) == ' ' || trim($a) == ' ' || trim($a) == '\xC2\xA0' || $a == ' ' || $a == ' ' || $a == ''))
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

  if ( ! function_exists('numberToTextAux'))
  {
    /**
     * Auxiliary function to convert number to text
     *
     * @param  string  $value
     *
     * @return array
     */
    function numberToTextAux($e, $thousand)
    {
      $exactNumbers =
        array(
          1 => Lang::get('numbers.1'),
          2 => Lang::get('numbers.2'),
          3 => Lang::get('numbers.3'),
          4 => Lang::get('numbers.4'),
          5 => Lang::get('numbers.5'),
          6 => Lang::get('numbers.6'),
          7 => Lang::get('numbers.7'),
          8 => Lang::get('numbers.8'),
          9 => Lang::get('numbers.9'),
          10 => Lang::get('numbers.10'),
          11 => Lang::get('numbers.11'),
          12 => Lang::get('numbers.12'),
          13 => Lang::get('numbers.13'),
          14 => Lang::get('numbers.14'),
          15 => Lang::get('numbers.15'),
          16 => Lang::get('numbers.16'),
          17 => Lang::get('numbers.17'),
          18 => Lang::get('numbers.18'),
          19 => Lang::get('numbers.19'),
          20 => Lang::get('numbers.20'),
          30 => Lang::get('numbers.30'),
          40 => Lang::get('numbers.40'),
          50 => Lang::get('numbers.50'),
          60 => Lang::get('numbers.60'),
          70 => Lang::get('numbers.70'),
          80 => Lang::get('numbers.80'),
          90 => Lang::get('numbers.90'),
          100 => Lang::get('numbers.100'),
          200 => Lang::get('numbers.200'),
          300 => Lang::get('numbers.300'),
          400 => Lang::get('numbers.400'),
          500 => Lang::get('numbers.500'),
          600 => Lang::get('numbers.600'),
          700 => Lang::get('numbers.700'),
          800 => Lang::get('numbers.800'),
          900 => Lang::get('numbers.900'),
      );

      if(array_key_exists($e, $exactNumbers) && $e!=100)
      {
        return $exactNumbers[$e];
      }

      $dozensHundreds =
        array(
          20 => Lang::get('numbers.dh20'),
          30 => Lang::get('numbers.dh30'),
          40 => Lang::get('numbers.dh40'),
          50 => Lang::get('numbers.dh50'),
          60 => Lang::get('numbers.dh60'),
          70 => Lang::get('numbers.dh70'),
          80 => Lang::get('numbers.dh80'),
          90 => Lang::get('numbers.dh90'),
        );

      if($e<100)
      {
        return $dozensHundreds[$e - $e%10] . $exactNumbers[$e%10];
      }
      elseif($e==100)
      {
        return Lang::get('numbers.cien');
      }
      elseif($e<1000)
      {
        return $exactNumbers[$e - $e%100] . numberToTextAux($e%100,0);
      }

      // $threeFigures =
      //   array(
      //     '',
      //     'mil ',
      //     'millones ',
      //     'mil ',
      //     'billones ',
      //     'mil ',
      //     'trillones '
      // );

      $threeFigures =
        array(
          '',
          Lang::get('numbers.mil'),
          Lang::get('numbers.millones'),
          Lang::get('numbers.mil'),
          Lang::get('numbers.billones'),
          Lang::get('numbers.mil'),
          Lang::get('numbers.trillones'),
      );

      if((($e - $e%1000) / 1000)==1)
      {
        return Lang::get('numbers.un') . str_replace(Lang::get('numbers.es'), '', $threeFigures[$thousand + 1]) . numberToTextAux($e%1000,0);
      }
      else
      {
        if(((($e - $e%1000)/1000)%1000)!=0 || $thousand%2!=0)
        {
          return numberToTextAux(($e - $e%1000) / 1000, $thousand + 1) . $threeFigures[$thousand + 1] . numberToTextAux($e%1000,0);
        }
        else
        {
          return numberToTextAux(($e - $e%1000) / 1000, $thousand + 1) . numberToTextAux($e%1000,0);
        }
      }
    }
  }

  if ( ! function_exists('numberToText'))
  {
    /**
     * Convert number to text
     *
     * @param  string  $value
     *
     * @return array
     */
    function numberToText($c, $upperCase=true, $currencyName='')
    {
      $c=sprintf('%0.2f',$c);
			$cents=round(($c - floor($c)) * 100);
			$amount=floor($c);

			settype($amount, 'integer');

			$cents.='';

			while(strlen($cents)<2)
				$cents='0' . $cents;

			if(!$upperCase)
      {
        return numberToTextAux($amount, 0) . $cents . '/100 ' . $currencyName;
      }
			else
      {
        return strtoupper(numberToTextAux($amount, 0) . $cents . '/100 ' . $currencyName);
      }
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

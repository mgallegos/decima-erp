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
          case 'nu': //is null
            $filter['op'] = 'is null';
            $filter['data'] = '';
            break;
      		case 'nn': //is not null
            $filter['op'] = 'is not null';
            $filter['data'] = '';
           	break;
        	case 'btw': //between
						$filter['op'] = 'between';
						break;
				}
			}
    }
  }

  if ( ! function_exists('array_only_sorted_by_key_position'))
  {
    /**
     * Get a subset of the items from the given array in the same order as the given key array
     *
     * @param  string  $value
     *
     * @return array
     */
    function array_only_sorted_by_key_position($array, $keys, $defaultValueIfKeyNotExist = null)
    {
      foreach ($keys as $index => $key)
      {
        if(array_key_exists($key, $array))
        {
          $newArray[$key] = $array[$key];
        }
        else
        {
          $newArray[$key] = $defaultValueIfKeyNotExist;
        }
      }

      return $newArray;
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
          0 => Lang::get('numbers.0'),
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
        // return Lang::get('numbers.un') . str_replace(Lang::get('numbers.es'), '', $threeFigures[$thousand + 1]) . numberToTextAux($e%1000,0);
        return Lang::get('numbers.un') . str_replace(Lang::get('numbers.es'), '', $threeFigures[$thousand + 1]) . ($e%1000!=0?numberToTextAux($e%1000,0):'');
      }
      else
      {
        if(((($e - $e%1000)/1000)%1000)!=0 || $thousand%2!=0)
        {
          // return numberToTextAux(($e - $e%1000) / 1000, $thousand + 1) . $threeFigures[$thousand + 1] . numberToTextAux($e%1000,0);
          return numberToTextAux(($e - $e%1000) / 1000, $thousand + 1) . $threeFigures[$thousand + 1] . ($e%1000!=0?numberToTextAux($e%1000,0):'');
        }
        else
        {
          // return numberToTextAux(($e - $e%1000) / 1000, $thousand + 1) . numberToTextAux($e%1000,0);
          return numberToTextAux(($e - $e%1000) / 1000, $thousand + 1) . ($e%1000!=0?numberToTextAux($e%1000,0):'');
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

  if ( ! function_exists('buildUserApps'))
  {
    /**
     * R....
     *
     * @param array userApps
     * 	An array of objects as follows: [ { name: $moduleName, icon: $icon, childsMenus: [ { name: $menuName, url: $url, aliasUrl: $aliasUrl, actionButtonId: $actionButtonId, icon: $icon, hidden: $hidden, childsMenus: [ { … },… ] },… ] },…]
     *
     * @return void
     */
    function buildUserApps($userApps, $dashboardMenuIsVisible = false, $organizationMenuIsVisible = false, $userOrganizations = array(), $id = 'core-menu', $doNothing = false)
    {
      if(count($userApps) == 0)
    	{
    		return;
    	}

    	$modules = '';

      if($dashboardMenuIsVisible)
      {
        $modules .= '<li><a href="#" onclick="$(\'#top-navbar-menu\').click();loadPage(\'/dashboard\');"><i class="fa fa-dashboard"></i> ' . Lang::get('dashboard.appName') . '</a></li>';
      }

      foreach ($userApps as $index => $value)
      {
        $modules .= '<li><span><i class="' . $value['icon'] . '"></i> ' . $value['name'] . '</span><ul>';
        $subModules = '';

    		if(!$value['childsMenus'][0]['url'])
    		{
    			$subModules .= buildSubModules($value['childsMenus'], $doNothing);
    		}
    		else
    		{
    			$subModules .= buildApps($value['childsMenus'], $doNothing);
    		}

        $modules .= ($subModules . '</ul></li>');
      }

      if($organizationMenuIsVisible && count($userOrganizations) > 1)
      {
        $modules .= '<li><span><i class="fa fa-sitemap"></i> ' . Lang::get('base.userOrganizations') . '</span><ul>';

        foreach ($userOrganizations as $index => $value)
        {
          $modules .= '<li><a href="#" onclick="$(\'#top-navbar-menu\').click();changeLoggedUserOrganization(\'' . $value['id'] . '\');"><i class="fa fa-building-o"></i> ' . $value['name'] . '</a></li>';
        }

        $modules .= '</ul></li>';
      }

      // echo '
      //   <nav id="' . $id . '">
      //     <ul>
      //       <li><a href="/"><i class="fa fa-code"></i> Home</a></li>
      //       <li><span><i class="fa fa-code"></i> About us</span>
      //         <ul>
      //           <li><a href="/about/history"><i class="fa fa-code"></i> History</a></li>
      //           <li><a href="/about/team">The team</a></li>
      //           <li><a href="/about/address">Our address</a></li>
      //         </ul>
      //       </li>
      //       <li><a href="/contact">Contact</a></li>
      //    </ul>
      //   </nav>
      // ';

      echo '
        <nav id="' . $id . '">
          <ul>
            ' . $modules . '
          </ul>
        </nav>
      ';
    }
  }

  if ( ! function_exists('buildSubModules'))
  {
    /**
     * Build HTML code of user submodules
     *
     * @param array subModules
     * 	An array of objects as follows: [ { name: $menuName, url: $url, aliasUrl: $aliasUrl, actionButtonId: $actionButtonId, icon: $icon, hidden: $hidden, childsMenus: [ { … },… ] },… ]
     *
     *  @returns string
     */
    function buildSubModules($childs, $doNothing)
    {
    	$subModules = '';

      foreach ($childs as $index => $value)
      {
        $subModules .= '<li><span><i class="' . $value['icon'] . '"></i> ' . $value['name'] . '</span><ul>';
        $subSubModules = '';

    		if(!$value['childsMenus'][0]['url'])
    		{
    			$subSubModules .= buildSubModules($value['childsMenus'], $doNothing);
    		}
    		else
    		{
    			$subSubModules .= buildApps($value['childsMenus'], $doNothing);
    		}

        $subModules .= ($subSubModules . '</ul></li>');
      }

      return $subModules;
    }
  }

  if ( ! function_exists('buildApps'))
  {
    /**
     * Build HTML code of user apps
     *
     * @param array apps
     * 	An array of objects as follows: [ { name: $menuName, url: $url, icon: $icon},… ]
     *
     *  @returns string
     */
    function buildApps($apps, $doNothing)
    {
    	$html = '';

      foreach ($apps as $index => $value)
      {
        if(!empty($value['hidden']))
        {
          continue;
        }

        if($doNothing)
        {
          $html .= '<li><a href="#"><i class="' . $value['icon'] . '"></i> ' . $value['name'] . '</a></li>';
        }
        else
        {
          $html .= '<li><a href="#" onclick="$(\'#top-navbar-menu\').click();loadPage(\'' . $value['url'] . '\', \'' . $value['aliasUrl'] . '\', \''. $value['actionButtonId'] .'\');"><i class="' . $value['icon'] . '"></i> ' . $value['name'] . '</a></li>';
        }
      }

    	return $html;
    }
  }

  if ( ! function_exists('nameFromTokenfield'))
  {
    /**
    * Get label from journal
    *
    * @param string $tokens
    * @param EloquentRepository
    *
    * @return string
    */
    function nameFromTokenfield($tokens, $EloquentRepository)
    {
      $result = '';

      if(empty($tokens))
      {
        return $result;
      }

      $tokenList = explode(",", $tokens);

      foreach($tokenList as $token)
      {
        $Repository = $EloquentRepository->byId((integer)$token);

        if(empty($result))
        {
          $result =  $Repository->name;
        }
        else
        {
          $result = $result . ", " . $Repository->name;
        }
      }

      return $result;
    }
  }

  if ( ! function_exists('generateStatusSqlCaseWhen'))
  {
    /**
    * Generate mobile grid HTML row
    *
    * @param string $tokens
    * @param EloquentRepository
    *
    * @return string
    */
    function generateStatusSqlCaseWhen($columnName)
    {
      return '
        CASE
          ' . $columnName . '
        WHEN \'A\' THEN
          \'' . Lang::get('form.A') . '\'
        WHEN \'P\' THEN
          \'' . Lang::get('form.P') . '\'
        WHEN \'U\' THEN
          \'' . Lang::get('form.U') . '\'
        WHEN \'X\' THEN
          \'' . Lang::get('form.X') . '\'
        WHEN \'Y\' THEN
          \'' . Lang::get('form.Y') . '\'
        END
      ';
    }
  }

  if ( ! function_exists('generateMobileGridHtmlRow'))
  {
    /**
    * Generate mobile grid HTML row
    *
    * @param string $tokens
    * @param EloquentRepository
    *
    * @return string
    */
    function generateMobileGridHtmlRow($cell1, $cell2, $cell3, $cell4)
    {
      return '
        CONCAT(
          \'<table class="mobile-grid"><tbody><tr class="mobile-grid-first-row"><td>\',
          ' . $cell1 . ',
          \'</td><td>\',
          ' . $cell2 . ',
          \'</td></tr><tr class="mobile-grid-second-row"><td>\',
          ' . $cell3 . ',
          \'</td><td>\',
          ' . $cell4 . ',
          \'</td></tr></tbody></table>\'
        )
      ';
    }
  }

  if ( ! function_exists('letterToNumber'))
  {
    /**
     * Convert letter to number
     *
     * @param  string  $value
     *
     * @return array
     */
    function letterToNumber($letter)
    {
      return ord(strtolower($letter)) - 97;
    }
  }

  if ( ! function_exists('encode_requested_data'))
  {
    /**
     * Enconde requested data
     *
     * @param  array $input
     * @param  integer $count total number of records
     * @param  integer $limit number of rows to be shown into the grid
     * @param  integer $offset start position
     *
     * @return array
     */
    function encode_requested_data($input, $count, &$limit, &$offset)
    {
      if(!empty($input['page']))
      {
        $page = (int)$input['page'];
      }
      else
      {
        $page = 1;
      }

      if(!empty($input['rows']))
      {
        $limit = (int)$input['rows'];
      }
      else
      {
        // $limit = 10;
        $limit = $count;
      }

      if($page == 0)
  		{
  			$page = 1;
  		}

      if($count > 0)
  		{
  			$totalPages = ceil($count/$limit);
  		}
  		else
  		{
  			$totalPages = 0;
  		}

      if($page > $totalPages)
  		{
  			$page = $totalPages;
  		}

  		if ($limit < 0 )
  		{
  			$limit = 0;
  		}

      $offset = $limit * $page - $limit;

  		if ($offset < 0)
  		{
  			$offset = 0;
  		}

  		// $limit = $limit * $page;
    }
  }

  if ( ! function_exists('boolean_value'))
  {
    /**
     * Return boolean representation of a string, integer or even a boolean
     *
     * @param mixed $value
     *
     * @return array
     */
    function boolean_value($value)
    {
      return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
  }

  if ( ! function_exists('set_custom_mail_settings'))
  {
    /**
     * R....
     *
     * @param  string  $value
     *
     * @return array
     */
    function set_custom_mail_settings($key)
    {
      $settings = Config::get('system-security.custom_mail');
      
      if(isset($settings[$key]))
      {
        app()->forgetInstance('swift.transport');
        app()->forgetInstance('swift.mailer');
        app()->forgetInstance('mailer');
        
        Config::set('mail.driver', $settings[$key]['driver']);
        Config::set('mail.host', $settings[$key]['host']);
        Config::set('mail.port', $settings[$key]['port']);
        Config::set('mail.from', $settings[$key]['from']);
        Config::set('mail.encryption', $settings[$key]['encryption']);
        Config::set('mail.username', $settings[$key]['username']);
        Config::set('mail.password', $settings[$key]['password']);
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

  if ( ! function_exists('ab'))
  {
    /**
     * R....
     *
     * @param  string  $value
     *
     * @return array
     */
    function ab($a, $b)
    {
      return $a + $b;
    }
  }

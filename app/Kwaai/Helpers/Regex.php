<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Helpers;

//Regex Library: http://www.regexlib.com/
//Regex validators: http://tools.netshiftmedia.com/regexlibrary/
//Regex syntax: http://www.w3schools.com/jsref/jsref_obj_regexp.asp

class Regex
{	
	protected $locale;
	protected $splitDelimiter = 'split';
	protected $date;
	protected $year = '^[0-9]{4}$';
	protected $positiveInteger = '^([1-9]{1}[0-9]{0,2}(\,[0-9]{3})*|[1-9]{1}[0-9]{0,}|0)$'; // 1,000,000 | 1000000 | 1000 | 0
	protected $positiveIntegerNoZero ='^([1-9]{1}[0-9]{0,2}(\,[0-9]{3})*|[1-9]{1}[0-9]{0,})$'; // 1,000,000 | 1000000 | 1000
	protected $signedInteger = '^(\+|-)?([1-9]{1}[0-9]{0,2}(\,[0-9]{3})*|[1-9]{1}[0-9]{0,}|0)$';// -1,000,000.00 | +1,000,000.00 | 1,000,000.00 | 1000000.00 | 1000 | 0
	protected $money = '^\$?([1-9]{1}[0-9]{0,2}(\,[0-9]{3})*(\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\.[0-9]{0,2})?|0(\.[0-9]{0,2})?|(\.[0-9]{1,2})?)$';// 1,000,000.00 | 1000000.00 | 1000000
	protected $dui = '^[0-9]{8}-[0-9]$'; //12345678-1
	protected $nit = '^[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]$';//1234-123456-123-1
	
	public function __construct($locale) 
	{
		$this->locale = $locale;
	}
	
	protected function stringFormat($langId,$regex,$allowedCharactersRegex='')
	{
		if($allowedCharactersRegex != '')
			return $langId.$this->splitDelimiter.$regex.$this->splitDelimiter.$allowedCharactersRegex;
		else
			return $langId.$this->splitDelimiter.$regex;
	}
		
	public function getDate()
	{
		if($this->locale =='es') 
		{
			//Date format: dd/mm/yyyy
			$this->date = '^([1-9]|[0,1,2][0-9]|3[0,1])/([\d]|0[0-9]|1[0,1,2])/\d{4}$';
		}
		else if ($this->locale =='en')
		{
			//Date format: mm/dd/yyyy
			$this->date = '^([\d]|0[0-9]|1[0,1,2])/([1-9]|[0,1,2][0-9]|3[0,1])/\d{4}$';
		}
		return $this->stringFormat('date', $this->date);
	}

	public function setDate($date)
	{
	    $this->date = $date;
	}

	public function getYear()
	{
		//Regex to rectric user input, it allows: [0-9]
		$allowedCharactersRegex = '^\d$';
		
		return $this->stringFormat('year',$this->year, $allowedCharactersRegex);	    
	}

	public function setYear($year)
	{
	    $this->year = $year;
	}

	public function getPositiveInteger()
	{
		//Regex to rectric user input, it allows: [0-9] , 
		$allowedCharactersRegex = '^(\d|,)$';
		
		return $this->stringFormat('positiveInteger', $this->positiveInteger, $allowedCharactersRegex);
	}

	public function setPositiveInteger($positiveInteger)
	{
	    $this->positiveInteger = $positiveInteger;
	}

	public function getPositiveIntegerNoZero()
	{
		//Regex to rectric user input, it allows: [0-9] ,
		
		$allowedCharactersRegex = '^(\d|,)$';
		
		return $this->stringFormat('positiveIntegerNoZero',$this->positiveIntegerNoZero, $allowedCharactersRegex);
	}

	public function setPositiveIntegerNoZero($positiveIntegerNoZero)
	{
	    $this->positiveIntegerNoZero = $positiveIntegerNoZero;
	}

	public function getSignedInteger()
	{
		//Regex to rectric user input, it allows: [0-9] , - +
		$allowedCharactersRegex = '^(\d|,|\+|-)$';
		
		return $this->stringFormat('signedInteger',$this->signedInteger, $allowedCharactersRegex);
	}

	public function setSignedInteger($signedInteger)
	{
	    $this->signedInteger = $signedInteger;
	}

	public function getMoney()
	{
		// Regex to rectric user input, it allows: [0-9] , .
		$allowedCharactersRegex = '^(\d|,|\.)$';
		 		
		return $this->stringFormat('money',$this->money, $allowedCharactersRegex);	    
	}

	public function setMoney($money)
	{
	    $this->money = $money;
	}

	public function getDui()
	{
		//Regex to rectric user input, it allows: [0-9] -
		$allowedCharactersRegex = '^(\d|-)$';
		
		return $this->stringFormat('dui',$this->dui, $allowedCharactersRegex);
	}

	public function setDui($dui)
	{
	    $this->dui = $dui;
	}

	public function getNit()
	{
		//Regex to rectric user input, it allows: [0-9] -
		$allowedCharactersRegex = '^(\d|-)$';
		
		return $this->stringFormat('nit', $this->nit, $allowedCharactersRegex);
	}

	public function setNit($nit)
	{
	    $this->nit = $nit;
	}
}
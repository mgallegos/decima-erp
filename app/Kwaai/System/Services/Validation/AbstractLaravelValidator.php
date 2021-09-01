<?php
/**
 * @file
 * Validation service.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\System\Services\Validation;

use Illuminate\Validation\Factory;
use Illuminate\Support\Str;

abstract class AbstractLaravelValidator implements ValidableInterface {

	/**
	 * Validation data key => value array
	 *
	 * @var Array
	 */
	protected $data = array();

	/**
	 * Validation errors
	 *
	 * @var Array
	 */
	protected $errors = array();

	/**
	 * Validation rules
	 *
	 * @var Array
	 */
	protected $rules = array();

	/**
	 * Custom validation messages
	 *
	 * @var Array
	 */
	protected $messages = array();

	/**
	 * Database Connection Name
	 *
	 * @var string
	 */
	protected $databaseConnectionName;

	/**
	 * Set data to validate
	 *
	 * @return \Impl\Service\Validation\AbstractLaravelValidator
	 */
	public function with(array $data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Test if validation passes or fails
	 *
	 * @return Boolean
	 */
	public function passes()
	{
		$Validator = $this->Validator->make(
			$this->data,
			$this->rules,
			$this->messages
		);

		if( $Validator->fails() )
		{
			$this->errors = $Validator->messages();

			return false;
		}

		return true;
	}

	/**
	 * Test if validation fails or passes
	 *
	 * @return Boolean
	 */
	public function fails()
	{
		$Validator = $this->Validator->make(
			$this->data,
			$this->rules,
			$this->messages
		);

		if( $Validator->fails() )
		{
			$this->errors = $Validator->messages();

			return true;
		}

		return false;
	}

	/**
	 * Return errors, if any
	 *
	 * @return object
	 */
	public function errors()
	{
		return $this->errors;
	}

	/**
	 * Organize an array with field and its corresponding validation message
	 *
	 * @return array
	 */
	function singleMessageStringByField()
	{
		$validations = array();

		foreach ($this->errors->toArray() as $key => $messages)
		{
			$validations = array_add($validations, $key, implode($messages, '<br>'));
		}

		return $validations;
	}

	/**
	 * Open database transactions
	 *
	 * @param boolean $openTransaction
	 * @param string $databaseConnectionName
	 *
	 * @return array
	 */
	function beginTransaction($openTransaction, $databaseConnectionName = null)
	{
		if(!$openTransaction)
		{
			return;
		}

		// $this->beginTransaction($openTransaction, $databaseConnectionName);
	  // $this->commit($openTransaction);
	  // $this->rollBack($openTransaction);

		$this->currentAttempt = 1;

		if(empty($databaseConnectionName))
    {
      $this->databaseConnectionName = $this->AuthenticationManager->getCurrentUserOrganizationConnection();
    }
		else
		{
			$this->databaseConnectionName = $databaseConnectionName;
		}

		$this->DB->beginTransaction();

    if(!$this->AuthenticationManager->isDefaultDatabaseConnectionName($this->databaseConnectionName))
    {
      $this->DB->connection($this->databaseConnectionName)->beginTransaction();
    }
	}

	/**
	 * Commit database transactions
	 *
	 * @param boolean $openTransaction
	 *
	 * @return array
	 */
	function commit($openTransaction)
	{
		if(!$openTransaction)
		{
			return;
		}

		$this->DB->commit();

		if(!$this->AuthenticationManager->isDefaultDatabaseConnectionName($this->databaseConnectionName))
    {
      $this->DB->connection($this->databaseConnectionName)->commit();
    }
	}

	/**
	 * RollBack database transactions
	 *
	 * @param boolean $openTransaction
	 *
	 * @return array
	 */
	function rollBack($openTransaction)
	{
		// if(!$openTransaction)
		// {
		// 	return;
		// }

		$this->DB->rollBack();

		// var_dump($this->databaseConnectionName);die();

		if(!$this->AuthenticationManager->isDefaultDatabaseConnectionName($this->databaseConnectionName))
    {
      $this->DB->connection($this->databaseConnectionName)->rollBack();
    }
	}

	/**
	 * Was exception caused by a deadlock
	 *
	 * @param boolean $openTransaction
	 *
	 * @return array
	 */
	function causedByDeadlock($e)
	{
		$message = $e->getMessage();
    
		$causedByDeadlock =  Str::contains($message, [
			'Deadlock found when trying to get lock',
			'deadlock detected',
			'The database file is locked',
			'database is locked',
			'database table is locked',
			'A table in the database is locked',
			'has been chosen as the deadlock victim',
			'Lock wait timeout exceeded; try restarting transaction',
			'WSREP detected deadlock/conflict and aborted the transaction. Try restarting the transaction',
		]);

		if ($causedByDeadlock && $this->currentAttempt > 1)
		{
			$this->currentAttempt--;
			return true;
		}
		else
		{
			return false;
		}
	}

}

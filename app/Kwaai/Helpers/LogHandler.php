<?php
/**
 * @file
 * Application listeners.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Helpers;

use Illuminate\Http\Request;

use Illuminate\Log\Writer;

class LogHandler
{
  /**
   * Log
   *
   * @var Illuminate\Log\Writer
   */
  protected $Log;
  
  /**
   * Input
   *
   * @var Illuminate\Http\Request
   *
   */
  protected $Input;

  public function __construct(Writer $Log, Request $Input)
  {
    $this->Log = $Log;
    
    $this->Input = $Input;
  }

  public function error($job, $exception)
  {
  	$this->Log->error($exception, array('post' => $this->Input->all(), 'jsonPost' => $this->Input->json()->all()));
  	
    $job->delete();
  }
  
  public function notice($job, $data)
  {
  	$this->Log->notice($data['message'], $data['context']);
  	 
  	$job->delete();
  }
  
  public function info($job, $data)
  {
  	$this->Log->info($data['message'], $data['context']);
  
  	$job->delete();
  }
  
  public function warning($job, $data)
  {
  	$this->Log->warning($data['message'], $data['context']);
  
  	$job->delete();
  }
}
